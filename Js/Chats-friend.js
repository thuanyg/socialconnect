var userID = $("input[name='txtUserid']").val();
$(document).ready(function () {
    var chatUserIDQuery = $("input[name='txtChatUserid']").val();
    if (chatUserIDQuery.trim() != "") {
        $(".message-tab").each(function () {
            if (chatUserIDQuery == $(this).data('friend-userid')) {
                $(".message-preview").removeClass("active-message");
                $(this).addClass("active-message");
                this.click();
                return false;
            }
        })
    }

    $("#new-message").on("click", function (e) {
        $(".message-content").empty();
        var html = `<div class="messages-headline">
                                <span>To: </span>              
                                <input style="width: 50%; display: inline-block" value="" name="txtSearch" type="text" class="form-control" placeholder="Search for Friends" autocomplete="off">
                                <div style="width: 46%" uk-drop="mode: click" class="header_search_dropdown">
                                    <h4 style="font-size:16px; margin-left: 10px;" class="search_title">Friends chat</h4>
                                    <ul id="search-m-Results"></ul>
                                </div>
                            </div>                     
                            `;
        $(".message-content").append(html);
        $("input[name='txtSearch']").focus();
    });
});


// Xóa tin nhắn cũ nhất (Chỉ xóa trên giao diện)
function deleteOldestMessage() {
    var messages = $('.message-content-inner');
    for (var i = 0; i < 2; i++) {
        messages.children().eq(0).remove();
    }
}

// ----------------<!--Phần xử lý các sự kiện trên giao diện-->--------------------------------------
var optionIsShowing = false;
$(document).on('mouseenter', '.message-text , .flex-custom', function (e) {
    var option_message = $(this).next(".flex-custom");
    option_message.css('display', "flex");
});


// Ấn phím enter thực hiện gửi
$(document).on('keypress', 'textarea[name="taMessage"]', function (e) {
    if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        $(".send-submit").click();
    }
});

// Sự kiện cho ô textarea
$(document).on('input', 'textarea[name="taMessage"]', function (e) {
    $(this).css('height', 'auto');
    $(this).css('height', $(this).scrollTop() + 'px');
});

// Sự kiện phần side bar - info chat bên phải
$(document).on("click", ".m-custom-chat div", function (e) {
    var ul = $(".list-custom-chat");
    if (ul.css('display') == "none") {
        ul.fadeIn();
    } else ul.fadeOut(100);
});
$(document).on("click", ".m-media-chat div", function (e) {
    var ul = $(".list-media-chat");
    if (ul.css('display') == "none") {
        ul.fadeIn();
    } else ul.fadeOut(100);
});
$(document).on("click", ".m-privacy-chat div", function (e) {
    var ul = $(".list-privacy-chat");
    if (ul.css('display') == "none") {
        ul.fadeIn();
    } else ul.fadeOut(100);
});
$(document).on("click", ".message-option .btn-search-message", function (e) {
    var ul = $(".search-message");
    if (ul.css('display') == "none") {
        ul.fadeIn();
    } else ul.fadeOut(100);
});
// $(document).on("click", ".messages-headline .message-menu-btn", function(e) {
//     var menu_right = $(".message-option");
//     if (menu_right.css('display') == "none") {
//         menu_right.fadeIn();
//     } else {
//         menu_right.css('background', '#ccc');
//         menu_right.css('position', 'absolute');
//         menu_right.fadeOut(100);
//     }
// });
// Show image in chat room
$(document).on("click", ".image-chat-inner", function (e) {
    $("#expandedImg").attr("src", $(this).attr("src"));
    $("#imageOverlay").fadeIn();
});

// Previous Image
$(document).on("click", ".pre-image", function (e) {
    var img_current = $(this).siblings('img').attr('src');
    var img_all = $(".message-content-inner .image-chat img");
    var previousImage;

    img_all.each(function (index) {
        if ($(this).attr('src') === img_current) {
            previousImage = img_all.eq(index - 1);
            return false; // Dừng vòng lặp khi tìm thấy ảnh trước đó
        }
    });

    if (previousImage) {
        var previousSrc = previousImage.attr('src');
        $("#expandedImg").attr("src", previousSrc);
        console.log("Switched to previous image");
    }
});
// Next Image
$(document).on("click", ".next-image", function (e) {
    var img_current = $(this).siblings('img').attr('src');
    var img_all = $(".message-content-inner .image-chat img");
    var nextImage;

    img_all.each(function (index) {
        if ($(this).attr('src') === img_current) {
            nextImage = img_all.eq(index + 1);
            return false; // Dừng vòng lặp khi tìm thấy ảnh trước đó
        }
    });

    if (nextImage) {
        var previousSrc = nextImage.attr('src');
        $("#expandedImg").attr("src", previousSrc);
        console.log("Switched to previous image");
    }
});

// Khởi tạo Picker
let isPickerVisible = false; // Biến để kiểm tra xem Picker có đang hiển thị hay không
$(document).on("click", ".emojiPicker-item", function (e) {
    e.preventDefault();
    if (!isPickerVisible) {
        const pickerOptions = {
            onEmojiSelect: function (emoji) {
                const emojiValue = emoji.native; // Lấy giá trị emoji
                $('textarea[name="taMessage"]').val(function (_, currentValue) {
                    return currentValue + emojiValue; // Thêm emoji vào giá trị hiện tại của textarea
                });
            }
        };
        const picker = new EmojiMart.Picker(pickerOptions);
        $('#emojiPicker').empty().show().append(picker);
        isPickerVisible = true;
    } else {
        $('#emojiPicker').empty().hide();
        isPickerVisible = false;
    }
});
// Show image/video preview
$(document).on("change", "#FileInput", function (e) {
    e.preventDefault();
    var fileInput = document.getElementById('FileInput');
    var filePreview = document.getElementById('imagePreview');
    filePreview.innerHTML = ''; // Xóa bất kỳ tệp trước nào đã được hiển thị trước đó.
    for (var i = 0; i < fileInput.files.length; i++) {
        var file = fileInput.files[i];
        var reader = new FileReader();
        var media = document.createElement(
            file.type.startsWith('video/') ? 'video' : file.type.startsWith('audio/') ? 'audio' : 'img'
        ); // Kiểm tra nếu là video, tạo một thẻ video, ngược lại tạo một thẻ img, audio
        media.style.display = 'inline-block';
        media.style.maxWidth = '200px';
        media.style.maxHeight = '200px';

        // Kiểm tra định dạng và kích thước của tệp trước khi xem trước
        if (file.type.startsWith('image/') || file.type.startsWith('video/') || file.type.startsWith('audio/') && file.size <= (5 * 1024 * 1024)) {
            reader.onload = (function (element) {
                return function (e) {
                    if (element.tagName.toLowerCase() === 'img') {
                        element.src = e.target.result;
                    } else if (element.tagName.toLowerCase() === 'video') {
                        element.src = e.target.result;
                        element.controls = true; // Hiển thị các điều khiển video
                    } else if (element.tagName.toLowerCase() === 'audio') {
                        element.src = e.target.result;
                        element.controls = true; // Hiển thị các điều khiển video
                    }
                    filePreview.appendChild(element); // Thêm phần tử vào phần tử hiển thị trước
                };
            })(media);
            reader.readAsDataURL(file);
        } else {
            showNotification('Hãy chọn một tệp hình ảnh, âm thanh hoặc video và kích thước tối đa 5MB.');
        }
    }
});
// Cuộn tin nhắn đến dưới cùng
function scrollToBottom() {
    setTimeout(function () {
        var simplebarContent = $('.simplebar-content')[4];
        if (simplebarContent) {
            simplebarContent.scrollTop = simplebarContent.scrollHeight;
        }
    }, 100); // Adjust this time delay as needed
}

// Hàm để hiển thị hiệu ứng loading khi gửi AJAX request
function showLoading() {
    $('#loading').show();
}

// Hàm để ẩn hiệu ứng loading sau khi nhận dữ liệu từ AJAX
function hideLoading() {
    $('#loading').hide();
}

function openOverlay(imageUrl) {
    document.getElementById("expandedImg").src = imageUrl;
}

function closeOverlay() {
    document.getElementById("imageOverlay").style.display = "none";
}
// ----------------<!--End Event-->--------------------------------------
// ----------------<!--Phần xử lý ajax - logic -->--------------------------------------
// Khi click nút Send (Gửi tin nhắn)
async function sendMessage(btn) {
    const senderId = $("input[name='txtUserid']").val(); // ID of the sender user (assuming you have authentication in place)
    const receiverId = btn.getAttribute("data-receiver-id");
    const messageContent = $("textarea[name='taMessage']").val();
    var fileInput = document.getElementById('FileInput');
    isValid = true;
    if (fileInput.files.length == 0) {
        if (messageContent.trim() == "") {
            isValid = false;
            showNotification("Hãy nhập nội dung tin nhắn");
        }
    }
    try {
        var files = await UploadFile();
        var message = {
            senderId: senderId,
            receiverId: receiverId,
            messageContent: messageContent,
            media: files,
            action: "private"
        };
        if (isValid) {
            ws.send(JSON.stringify(message));
            // Set value TextArea empty
            $("textarea[name='taMessage']").val("");
            // Scroll to bottom
            scrollToBottom();
            // Delete old message
            deleteOldestMessage();
        }
    } catch (error) {
        console.error(error);
    }


}
// Upload image
async function UploadFile() {
    var formData = new FormData($("#uploadForm")[0]);
    return new Promise(function (resolve, reject) {
        formData.append('action', 'upload-file-message');
        $.ajax({
            url: "Ajax/Upload.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                var images = JSON.parse(response);
                resolve(images); // Trả về mảng images sau khi hoàn thành
            },
            error: function () {
                reject("Lỗi xảy ra khi tải ảnh lên.");
            }
        });
    });
}


$(".message-tab").on("click", function (e) {
    e.preventDefault();
    $(".message-tab").removeClass("active-message");
    $(this).addClass("active-message");
    var senderId = $("input[name='txtUserid']").val();
    var receiverId = $(this).attr("data-friend-userid"); // lấy id người nhận
    $(".message-content").empty();
    var html = `<div class="simplebar-content" style="padding: 0px; height: 100%; overflow: hidden scroll; padding: 0px;
                            height: 100%; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                        <img src="./assets/images/gif/loading_message_tab.svg" style="display: block; max-width: 100%; max-height: 100%;">
                    </div>`;
    $(".message-content").append(html);
    $.ajax({
        url: "Ajax/Message.php",
        method: "POST",
        dataType: "html",
        data: {
            receiverId: receiverId,
            senderId: senderId,
            action: "show-message"
        },
        success: function (data) {
            if (data) {
                $(".message-content").empty();
                $(".message-content").append(data);
                scrollToBottom();
            }
        }
    });

    // Event scroll
    // var totalMessage = 0;
    var offsetMessage = 15; // offset ban đầu
    var messFetching = false;
    var scrolledOnce = false;
    // var originalScrollTop = 0;

    setTimeout(function () {
        $('.simplebar-content:eq(4)').scroll(function () {
            var scrollTop = $(this).scrollTop();
            if (scrollTop < 50 && !scrolledOnce) {
                scrolledOnce = true;
                PreviousMessage();
            } else scrolledOnce = false;
        });
    }, 1000);

    // Get message
    function getMessage(offset) {
        messFetching = true;
        showLoading();
        setTimeout(function () {
            $.ajax({
                url: "Ajax/Message.php?offset=" + offset,
                method: "POST",
                dataType: "html",
                data: {
                    senderId: senderId,
                    receiverId: receiverId,
                    action: "get-message"
                },
                success: function (data) {
                    if (data.trim()) {
                        $(".message-content-inner").prepend(data);
                        hideLoading();
                    } else {
                        hideLoading();
                        return;
                    }
                    messFetching = false;
                }
            });
        }, 0);
    }

    //View previous message
    function PreviousMessage() {
        if (messFetching) return;
        getMessage(offsetMessage);
        offsetMessage += 5;
    }



    setTimeout(function () {
        $('textarea[name="taMessage"]').on('focus', function () {
            // Ví dụ: Gửi thông báo "stopped typing" tới server qua WebSocket
            ws.send(JSON.stringify({
                receiverId: receiverId,
                senderId: senderId,
                action: 'typing'
            }));
        });
    }, 100);

    setTimeout(function () {
        $('textarea[name="taMessage"]').on('blur', function () {
            // Ví dụ: Gửi thông báo "stopped typing" tới server qua WebSocket
            ws.send(JSON.stringify({
                receiverId: receiverId,
                senderId: senderId,
                action: 'not-typing'
            }));
        });
    }, 100);
});

// Click preview -> Enter chat
$(".message-preview").on("click", function (e) {
    e.preventDefault();
    var message_preview = $(this).data('friend-id');
    $(".message-tab").each(function () {
        if (message_preview == $(this).data('friend-userid')) {
            $(".message-preview").removeClass("active-message");
            $(this).addClass("active-message");
            this.click();
            return false;
        }
    });
});

// Tìm kiếm bb để chat
$(document).on("input", "input[name='txtSearch']", function (e) {
    var query = $("input[name='txtSearch']").val();
    if (query != "") {
        SearchFriendMessage(query.trim());
    }

    function SearchFriendMessage(query) {
        $.ajax({
            url: "Ajax/Search.php",
            type: "GET",
            data: {
                action: "search-message",
                query: query
            },
            dataType: "html",
            success: function (response) {
                if (response) {
                    $("#search-m-Results").empty();
                    $("#search-m-Results").append(response);
                }
            }

        })
    }
})
// Tim kiem lich su tin nhan
$(document).on('keypress', 'input[name="txtSearchMessage"]', function (e) {
    if (e.which === 13 && !e.shiftKey) {
        e.preventDefault();
        var query = $(this).val();
        var receiverID = $(this).parent().attr("data-receiver-id");
        findHistoryMessage(userID, receiverID, query);
    }
});

function findHistoryMessage(userID, receiverID, query) {
    if (query) {
        $.ajax({
            url: "Ajax/Search.php",
            type: "GET",
            data: {
                userID: userID,
                receiverID: receiverID,
                query: query,
                action: "find-history-message"
            },
            success: function (response) {
                if (response.trim().length) {
                    $(".message-search-result").show();
                    $(".list-history-message").empty();
                    $(".list-history-message").append(response);
                } else {
                    $(".message-search-result").show();
                    $(".list-history-message").empty();
                    $(".list-history-message").append("<div style='text-align:center; color: blue'>No results</div>");
                }
            },
        })
    }
}
// Click vào tin nhắn được tìm thấy -> scroll đến đúng vị trí
$(document).on('click', '.message-result-row', function (e) {
    // Reset font color
    $(".message-result-row").css('color', 'white');
    var clickedElement = $(this);
    var messID = $(this).data('message-id');
    console.log('messID:', messID);
    scrollMessage();

    function scrollMessage() {
        var elementToScrollTo = $('.message-text[data-message-id="' + messID + '"]');
        // Reset font color
        $('.message-text').css('background-color', '#2a41e8');
        if (elementToScrollTo.length > 0) {
            // Scroll into view
            $(".loading-history").empty();
            var html = `<div class="simplebar-content" style="padding: 0px; height: 100%; overflow: hidden scroll; padding: 0px;
                            height: 100%; overflow: hidden; display: flex; justify-content: center; align-items: center;">
                        <img src="./assets/images/gif/loading_message_tab.svg" style="display: block; max-width: 50%; max-height: 50%;">
                    </div>`;
            clickedElement.prev().append(html);
            clickedElement.css('color', '#20ff00');
            elementToScrollTo.css('background-color', '#16a76a');
            elementToScrollTo[0].scrollIntoView({
                behavior: 'smooth'
            });
            setTimeout(function () {
                // Scroll an additional 200 pixels up (adjust as needed)
                $('.simplebar-content:eq(4)').scrollTop($('.simplebar-content:eq(4)').scrollTop() - 230);
            }, 1000);
            setTimeout(function () {
                clickedElement.prev().empty();
            }, 500)
            return;
        }
    }

    function scrollLoad() {
        // Scroll đến vị trí 40 với hiệu ứng chậm
        $('.simplebar-content:eq(4)').animate({
            scrollTop: 40
        }, 1000);
    }
});

// Xóa full chat
function deleteConversation(btn) {
    const userid = $("input[name='txtUserid']").val();
    const receiverID = btn.getAttribute("data-receiver-id");
    if (confirm("Are you sure you want to delete this conversation?")) {
        $.ajax({
            url: "Ajax/Message.php",
            type: "POST",
            data: {
                userid: userid,
                receiverID: receiverID,
                action: "delete-conversation"
            },
            success: function (response) {
                if (response) {
                    showNotification("Delete succesfully");
                    $(".message-content-inner").empty();
                }
            },
        });
    }
}

// Xóa tin nhắn của mình
$(document).on("click", ".delete-one-chat", function (e) {
    var chatID = $(this).parent().attr("data-message-id");
    $(".deleteAll").show();
    showConfirmation();
    deleteOneChat(chatID, $(this));
    deleteAll(chatID, $(this));
});
// Xóa tin nhắn của người khác gửi tới
$(document).on("click", ".delete-one-chat-friend", function (e) {
    var chatID = $(this).parent().attr("data-message-id");
    $(".deleteAll").hide();
    showConfirmation();
    deleteOneChatFriend(chatID, $(this));
});

function deleteOneChat(chatID, deleteBtn) {
    $(".deleteOne").on('click', function (e) {
        $.ajax({
            url: "Ajax/Message.php",
            type: "POST",
            data: {
                chatID: chatID,
                action: "delete-one-chat"
            },
            success: function (data) {
                if (data) {
                    showNotification("Delete succesfully");
                    deleteElementRowChat(deleteBtn);
                }
            }
        });
        hideModal();
    })
}

function deleteOneChatFriend(chatID, deleteBtn) {
    $(".deleteOne").on('click', function (e) {
        $.ajax({
            url: "Ajax/Message.php",
            type: "POST",
            data: {
                chatID: chatID,
                action: "delete-one-chat-friend"
            },
            success: function (data) {
                if (data) {
                    showNotification("Delete succesfully");
                    deleteElementRowChat(deleteBtn);
                }
            }
        });
        hideModal();
    })
}

function deleteAll(chatID, deleteBtn) {
    $(".deleteAll").on('click', function (e) {
        $.ajax({
            url: "Ajax/Message.php",
            type: "POST",
            data: {
                chatID: chatID,
                action: "delete-chat"
            },
            success: function (data) {
                if (data) {
                    showNotification("Delete succesfully");
                    deleteElementRowChat(deleteBtn);
                }
            }
        });
        hideModal();
    })
}

function deleteElementRowChat(deleteBtn) {
    var message_me = deleteBtn.parent().parent().parent().parent();
    var time_sign = message_me.next();
    message_me.remove();
    time_sign.remove();
}
// Code model confirm
function showConfirmation() {
    var modal = document.getElementById('confirmationModal');
    modal.style.display = 'block';

    // Ẩn modal khi click ra ngoài
    window.addEventListener('click', function (event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

function hideModal() {
    var modal = document.getElementById('confirmationModal');
    modal.style.display = 'none';
}