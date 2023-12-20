<script type="text/javascript">
    // ----------------<!--Phần xử lý Websocket-->--------------------------------------
    const ws = new WebSocket('ws://192.168.88.105:8081?uid=<?php echo $_SESSION["userid"]; ?>');
    ws.onopen = () => {
        console.log('Connected to the server');
    };

    ws.onmessage = (event) => {
        const data = JSON.parse(event.data);
        console.log(data);
        var messageContent = data.messageContent;
        var messageDate = data.date;

        // Kiểm tra nếu data sever gửi về có key = from => Là tin nhắn
        if (data.from != null) {
            // Nếu là tin nhắn bản thân gửi đi
            if (data.from == "Me") {
                var html_media_tags = "";
                var media = data.media;
                media.forEach(item => {
                    var fileType = getFileType(item);
                    if (fileType === 'image') {
                        html_media_tags += `<div class="image-chat" style="text-align: right; margin: 10px;">\n
                                                <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" 
                                                src="./uploads/messages/${item}">
                                            </div>`;
                    } else if (fileType === 'video') {
                        html_media_tags += `<div class="w-full h-full" style="justify-content: right; display: flex;">
                                                <video controls>
                                                    <source src="./uploads/messages/${item}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                </video>
                                            </div>`;
                    } else if (fileType === 'audio') {
                        html_media_tags += `<div class="audio-chat" style="justify-content: right; display: flex;">\n
                                                <audio controls>
                                                    <source src="./uploads/messages/${item}" type="audio/mpeg">
                                                </audio>
                                            </div>`;
                    }
                });
                var html = `<div class="message-bubble me">
                                <div class="message-bubble-inner">
                                    <div class="message-avatar"><img src="<?php echo $userCurrent["avatar_image"] ?>" alt=""></div>
                                    <div class="message-text">
                                        <p>${messageContent}</p>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                                    ${html_media_tags}
                            </div>
                            <div class="message-time-sign">
                                <span>${messageDate}</span>
                            </div>`;
                // Chèn vào tin nhắn mỗi khi gửi
                if ($(".message-content-inner").children().length == 0) {
                    $(".message-content-inner").after(html);
                } else {
                    $(".message-content-inner .message-time-sign:last").after(html);
                }
                // Chèn vào phần message preview góc trên bên phải
                var receiverId = $(`[data-friend-id="${data.receiverId}"]`); // Lấy thẻ li 
                var mess = receiverId.find('p:first');
                mess.empty();
                mess.text(`Me: ${messageContent}`);
                // Chèn vào mục message preview sidebar bên trái 
                var receiverId = $(`[data-friend-userid="${data.receiverId}"]`); // Lấy thẻ li 
                var mess = receiverId.find('p:first');
                mess.empty();
                mess.text(`Me: ${messageContent}`);
            } else {
                // Nếu là tin nhắn đến
                var html_media_tags = "";
                var media = data.media;
                media.forEach(item => {
                    var fileType = getFileType(item);
                    if (fileType === 'image') {
                        html_media_tags += `<div class="image-chat" style="text-align: left; margin: 10px;">\n
                                                <img class="image-chat-inner" style="max-width: 200px; max-height: 200px; border-radius: 10px; display: inline-block;" 
                                                src="./uploads/messages/${item}">
                                            </div>`;
                    } else if (fileType === 'video') {
                        html_media_tags += `<div class="w-full h-full" style="justify-content: left; display: flex;">
                                                <video controls>
                                                    <source src="./uploads/messages/${item}" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                </video>
                                            </div>`;
                    } else if (fileType === 'audio') {
                        html_media_tags += `<div class="audio-chat" style="justify-content: left; display: flex;">\n
                                                <audio controls>
                                                    <source src="./uploads/messages/${item}" type="audio/mpeg">
                                                </audio>
                                            </div>`;

                    }

                });
                var avatarFriend = $(".avatar-image-friend-chat").attr("src");
                var html = `<div class="message-bubble">
                        <div class="message-bubble-inner">
                            <div class="message-avatar"><img src="${avatarFriend}" alt=""></div>
                                <div class="message-text">
                                    <p>${messageContent}</p>
                                </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="image-chat" style="text-align: right; margin: 10px;">
                            ${html_media_tags}
                        </div>
                    </div>
                    <div class="message-time-sign">
                        <span>${messageDate}</span>
                    </div>`;
                // Chèn vào tin nhắn mỗi khi nhận được từ ai đó
                if ($(".message-content-inner").children().length == 0) {
                    $(".message-content-inner").after(html);
                } else {
                    $(".message-content-inner .message-time-sign:last").after(html);
                }
                // Chèn vào phần message preview góc trên bên phải
                var receiverId = $(`[data-friend-id="${data.senderId}"]`); // Lấy thẻ li 
                // receiverId.addClass("un-read")
                var mess = receiverId.find('p:first');
                mess.empty();
                mess.text(`${messageContent}`);
                // Chèn vào mục message preview sidebar bên trái 
                var receiverId = $(`[data-friend-userid="${data.senderId}"]`); // Lấy thẻ li 
                var mess = receiverId.find('p:first');
                mess.empty();
                mess.text(`${messageContent}`);
            }
        }
        // Nếu tồn tại key = typer => đang nhập tin nhắn
        if (data.typer != null) {
            if (data.typer == "Me") {
                $(".message-typing").fadeOut();
            } else if (data.typer == $(".message-typing").attr("data-receivcer-id")) {
                $(".message-typing").fadeIn();
            }
        }
        // Nếu tồn tại key = not_typing => Hủy việc nhập tin nhắn
        if (data.not_typing != null) {
            if (data.not_typing != "Me") {
                $(".message-typing").fadeOut();
            }
        }
        scrollToBottom();
    };

    // Get file type
    function getFileType(fileName) {
        if (/\.(jpe?g|png|gif|webp|svg)$/i.test(fileName)) {
            return 'image';
        } else if (/\.(mp3|aac|flac|alac)$/i.test(fileName)) {
            return 'audio';
        } else if (/\.(mp4|webm|avi|ogg|flv|mkv)$/i.test(fileName)) {
            return 'video';
        } else {
            return 'unknown';
        }
    }
    // ----------------<!--Kết thúc xử lý Websocket-->-----------------------------------
    
</script>