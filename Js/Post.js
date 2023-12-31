

// Phần modal - Input Upload Video
$(".btn-input-video").click(function () {
    var _html = '<li><span onclick="DelVideo(this)" style="cursor: pointer" title="Delete">×</span>'
    _html += '<form method="POST" name="upload-video" enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadVideo(this)" /></form></li>';
    $('#imagePreview ul').append(_html);
    $('#imagePreview ul li').last().find('input[type="file"]').click();
})
$(".btn-input-edit-video").click(function () {
    var _html = '<li><span onclick="DelVideo(this)" style="cursor: pointer" title="Delete">×</span>'
    _html += '<form method="POST" name="upload-edit-video" hidden enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadEditVideo(this)" /></form></li>';
    $('#imageEditPreview ul').append(_html);
    $('#imageEditPreview ul li').last().find('input[type="file"]').click();
})
// Show video preview 
function uploadVideo(el) {
    var file_data = $(el).prop('files');
    for (var i = 0; i < file_data.length; i++) {
        var type = file_data[i].type;
        var fileToLoad = file_data[i];
        var fileReader = new FileReader();
        if (type.startsWith('video/') && file_data[i].size <= (50 * 1024 * 1024)) {
            fileReader.onload = function (fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result;
                var newVideo = document.createElement('video');
                newVideo.src = srcData;
                newVideo.controls = true;
                newVideo.style.display = 'inline-block';
                newVideo.style.maxWidth = '300px';
                newVideo.style.maxHeight = '300px';
                $('#imagePreview ul li:last').append(newVideo.outerHTML);
                $('#imagePreview ul li:last span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp video có kích thước tối đa 50MB.');
            $('#imagePreview ul li').last().remove();
        }
    }
}
// Show ảnh preview cho modal edit post
function uploadEditVideo(el) {
    var file_data = $(el).prop('files');
    for (var i = 0; i < file_data.length; i++) {
        var type = file_data[i].type;
        var fileToLoad = file_data[i];
        var fileReader = new FileReader();
        if (type.startsWith('video/') && file_data[i].size <= (50 * 1024 * 1024)) {
            fileReader.onload = function (fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result;
                var newVideo = document.createElement('video');
                newVideo.src = srcData;
                newVideo.controls = true;
                newVideo.style.display = 'inline-block';
                newVideo.style.maxWidth = '300px';
                newVideo.style.maxHeight = '300px';
                $('#imageEditPreview ul li:last').append(newVideo.outerHTML);
                $('#imageEditPreview ul li:last span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp video có kích thước tối đa 50MB.');
            $('#imageEditPreview ul li').last().remove();
        }
    }
}
// Xóa video preview
function DelVideo(btn) {
    btn.parentElement.remove();
}
// Phần modal - Input Upload Ảnh
$(".btn-input-image").click(function () {
    var _html = '<li><span onclick="DelImg(this)" style="cursor: pointer" title="Delete">×</span>'
    _html += '<form method="POST" name="upload-image" enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadImg(this)" /></form></li>';
    $('#imagePreview ul').append(_html);
    $('#imagePreview ul li').last().find('input[type="file"]').click();
})

// Áp dụng modal edit post
$(".btn-input-edit-image").click(function () {
    var _html = '<li><span onclick="DelImg(this)" style="cursor: pointer" title="Delete">×</span>'
    _html += '<form method="POST" name="upload-edit-image" hidden enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadEditImg(this)" /></form></li>';
    $('#imageEditPreview ul').append(_html);
    $('#imageEditPreview ul li').last().find('input[type="file"]').click();
})
// Show ảnh preview cho modal create post
function uploadImg(el) {
    var file_data = $(el).prop('files');
    for (var i = 0; i < file_data.length; i++) {
        var type = file_data[i].type;
        var fileToLoad = file_data[i];
        var fileReader = new FileReader();
        if (type.startsWith('image/') && file_data[i].size <= (5 * 1024 * 1024)) {
            fileReader.onload = function (fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result;
                var newImage = document.createElement('img');
                newImage.src = srcData;
                newImage.style.display = 'inline-block';
                newImage.style.maxWidth = '200px';
                newImage.style.maxHeight = '200px';
                $('#imagePreview ul li:last').append(newImage.outerHTML);
                $('#imagePreview ul li:last span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp hình ảnh có kích thước tối đa 5MB.');
            $('#imagePreview ul li').last().remove();
        }
    }
}
// Show ảnh preview cho modal edit post
function uploadEditImg(el) {
    var file_data = $(el).prop('files');
    for (var i = 0; i < file_data.length; i++) {
        var type = file_data[i].type;
        var fileToLoad = file_data[i];
        var fileReader = new FileReader();
        if (type.startsWith('image/') && file_data[i].size <= (5 * 1024 * 1024)) {
            fileReader.onload = function (fileLoadedEvent) {
                var srcData = fileLoadedEvent.target.result;
                var newImage = document.createElement('img');
                newImage.src = srcData;
                newImage.style.display = 'inline-block';
                newImage.style.maxWidth = '200px';
                newImage.style.maxHeight = '200px';
                $('#imageEditPreview ul li:last').append(newImage.outerHTML);
                $('#imageEditPreview ul li:last span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp hình ảnh có kích thước tối đa 5MB.');
            $('#imageEditPreview ul li').last().remove();
        }
    }
}
// Xóa ảnh preview
function DelImg(btn) {
    btn.parentElement.remove();
}


// Tải ảnh lên server
async function UploadFilesToServer(listForm) {
    var files = [];
    // var formfiles = $("form[name='upload-image']");
    for (let i = 0; i < listForm.length; i++) {
        var formData = new FormData(listForm[i]);
        formData.append('action', 'upload-file-post');
        try {
            var response = await $.ajax({
                url: "Ajax/Upload.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
            });
            var file = JSON.parse(response);
            files = files.concat(file);
        } catch (error) {
            console.error("Error uploading image:", error);
        }
    }
    return files;
}




// Tạo bài viết mới
async function CreatePost() {
    var post = $("textarea[name='taPost']").val();
    var userid = $("input[name='txtUserid']").val();
    var privacy = $("#create-post-modal").find(".dropdown-toggle .filter-option").text();
    var isValid = true;
    if (post.trim().length > 1000) {
        showNotification("Bài viết của bạn quá dài. Hãy kiểm tra lại");
        isValid = false;
    }
    if (post.trim().length == 0 && $("#imagePreview li").length === 0) {
        showNotification("Please enter text to create post!");
        isValid = false;
    }
    if (!containsExternalEmbed(post)) {
        post = escapeHtml(post);
    }
    try {
        if (isValid) {
            var formImages = $("form[name='upload-image']");
            var formVideos = $("form[name='upload-video']");
            var html = `<div class="loading-upload" style="overflow: hidden; display: flex; justify-content: center; align-items: center;">
                            <img src="./assets/images/gif/loading_createpost.svg" style="display: block; max-width: 100%; max-height: 100%;">
                        </div>`;
            $("#create-post-modal .uk-modal-dialog").append(html);
            showNotification("Uploading...");
            var images = await UploadFilesToServer(formImages);
            var videos = await UploadFilesToServer(formVideos);
            var media = images.concat(videos);
            if(media.length >= 10){
                showNotification("Chỉ chọn tối đa 10 tệp!");
                $(".loading-upload").remove();
                DeleteFilesFromServer(media);
                return;
            }
            $("#loader").show();
            setTimeout(() => {
                $.ajax({
                    url: "Ajax/Post.php",
                    method: "POST",
                    dataType: "html",
                    data: {
                        post: post,
                        userid: userid,
                        media: media,
                        privacy: privacy,
                        action: "create-post"
                    },
                    success: function (data) {
                        if (data.trim() != "") {
                            showNotification("You have successfully posted the article");
                            var PostContaier = document.getElementById('PostContaier');
                            PostContaier.firstElementChild.insertAdjacentHTML('afterend', data);
                            $("#create-post-modal .loading-upload").remove();
                            $("#create-post-modal #closeModelPost").click();
                            $("#loader").hide();
                            $("textarea[name='taPost']").val("");
                        } else {
                            showNotification("Something wrong!");
                        }
                    }
                });
            }, 1500);
        }
    } catch (error) {
        console.error(error);
    }
}


// Edit post
// var oldImages = [];
var filesAfter = [];
var filesDeleted = [];
$(document).on("click", ".post-action .post-action-edit", function (e) {
    var postID = $(this).attr('post-id');
    var editPostModal = $("#edit-post-modal");
    var imagePreview = $('#imageEditPreview ul');
    imagePreview.empty();
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: {
            postid: postID,
            action: "get-post"
        },
        success: function (response) {
            if (response) {
                var post = JSON.parse(response)[0];
                editPostModal.find("textarea").val(post.post);
                editPostModal.find(".Privacy .dropdown-toggle").attr('title', post.privacy);
                editPostModal.find(".Privacy .dropdown-toggle .filter-option").text(post.privacy);
                var optionElement = editPostModal.find(".Privacy select option").filter(function () {
                    return $(this).text() === post.privacy;
                });
                if (post.privacy == "Public") {
                    editPostModal.find(".Privacy .dropdown-menu li").removeClass("selected")
                    editPostModal.find(".Privacy .dropdown-menu li:eq(0)").addClass("selected")
                }
                if (post.privacy == "Friend") {
                    editPostModal.find(".Privacy .dropdown-menu li").removeClass("selected")
                    editPostModal.find(".Privacy .dropdown-menu li:eq(1)").addClass("selected")
                }
                if (post.privacy == "Private") {
                    editPostModal.find(".Privacy .dropdown-menu li").removeClass("selected")
                    editPostModal.find(".Privacy .dropdown-menu li:eq(2)").addClass("selected")
                }
                optionElement.attr('selected', 'selected');
                var media = JSON.parse(post.media)
                filesAfter = media;
                for (var i = 0; i < media.length; i++) {
                    if (getFileType(media[i]) == 'image') {
                        var img = document.createElement('img');
                        img.src = './uploads/posts/' + media[i];
                        img.style.display = 'inline-block';
                        img.style.maxWidth = '200px';
                        img.style.maxHeight = '200px';
                        var li = document.createElement('li');
                        li.innerHTML = '<span onclick="DeleteOldFiles(this)" style="cursor: pointer" title="Delete">×</span>';
                        li.appendChild(img)
                        imagePreview.append(li);
                    }
                    if (getFileType(media[i]) == 'video') {
                        var video = document.createElement('video');
                        video.src = './uploads/posts/' + media[i];
                        video.controls = true;
                        video.style.display = 'inline-block';
                        video.style.maxWidth = '300px';
                        video.style.maxHeight = '300px';
                        var li = document.createElement('li');
                        li.innerHTML = '<span onclick="DeleteOldFiles(this)" style="cursor: pointer" title="Delete">×</span>';
                        li.appendChild(video)
                        imagePreview.append(li);
                    }


                }
            }
        }
    })

    $(".save-edit-post").on('click', async function (e) {
        e.preventDefault();
        var postText = editPostModal.find("textarea").val();
        var privacy = editPostModal.find(".dropdown-toggle .filter-option").text();
        var formImages = $("form[name='upload-edit-image']");
        var imagesNew = await UploadFilesToServer(formImages);
        var formVideos = $("form[name='upload-edit-video']");
        var videosNew = await UploadFilesToServer(formVideos);
        var media = imagesNew.concat(videosNew).concat(filesAfter);
        //console.log(media);
        var isValid = true;
        if (postText.length > 1000) {
            showNotification("Bài viết của bạn quá dài. Hãy kiểm tra lại");
            isValid = false;
        }
        if (imagesNew.length == 0 && filesAfter.length == 0 && postText.length == 0) {
            showNotification("Chưa nhập thông tin cho bài đăng");
            isValid = false;
        }
        try {
            if (isValid) {
                $.ajax({
                    url: "Ajax/Post.php",
                    type: "POST",
                    data: {
                        postText: postText,
                        privacy: privacy,
                        postId: postID,
                        media: media,
                        action: "edit-post"
                    },
                    success: function (response) {
                        if (response) {
                            if (filesDeleted) {
                                DeleteFilesFromServer(filesDeleted);
                            }
                            window.location.reload();
                        }
                    }
                })
            }
        } catch (error) {
            console.error(error);
        }
    })
})
// Delete old image when edit post
function DeleteOldFiles(btn) {
    var srcFile = btn.nextSibling.src;
    var fileName = srcFile.match(/([^\/?#]+)$/);
    var parentElement = btn.parentElement;
    // Xóa phần tử cha (parentElement)
    parentElement.remove();
    if (fileName && fileName[1]) {
        // Tìm index của fileName[1] trong mảng filesAfter
        var file = decodeURIComponent(fileName[1]);
        var index = filesAfter.indexOf(file);
        // Nếu tìm thấy, loại bỏ phần tử từ mảng
        if (index !== -1) {
            if (filesDeleted.indexOf(file) === -1) {
                filesDeleted.push(file);
            }
            filesAfter.splice(index, 1);
        }
    }
    console.log(filesDeleted);
}

// Delete image from Server
function DeleteFilesFromServer(media) {
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: {
            media: media,
            action: "delete-media"
        },
        success: function (response) {
            if (response) {
                // console.log("Deleted! Images = " + images);
            }
        }
    })
}

// like post 
$(document).on('click', '.like-post-btn', function (e) {
    e.preventDefault();
    var userID = $("input[name='txtUserid']").val();
    var postID = $(this).parent().attr("post-id");
    var authorID = $(this).parent().attr("author-id");
    var likeButton = $(this);
    var data = {
        userid: userID,
        postid: postID,
        action: "like-post"
    };
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: data,
        success: function (response) {
            if (response.trim() == "1") {
                // Đổi màu button
                var likeIcon = likeButton.find("svg");
                var likeText = likeButton.find(".like-text");
                var showLikeElement = likeButton.parent().parent().find("div.dark\\:text-gray-100:eq(0)");
                var avatarUserLike = likeButton.parent().parent().find(".avatar-user-like");
                var avatarUserCurrent = $("input[name='txtUserAvatar']").val();
                if (likeIcon.attr("fill") == "currentColor") {
                    likeIcon.attr("fill", "blue");
                    likeText.css("color", "blue");
                    // Cập nhật lượt like => Like
                    var quantityLike = likeText.find("span");
                    var currentLikes = parseInt(quantityLike.text().replace(/\D/g, ''), 10);
                    if (!isNaN(currentLikes)) {
                        // Tăng giá trị lên 1 và cập nhật lại nội dung của thẻ <span>
                        var newLikes = currentLikes + 1;
                        quantityLike.text("(" + newLikes + ")");
                    }
                    var getOld = showLikeElement.text();
                    var html = "";
                    if (getOld.trim() != "") {
                        html += '<strong> You </strong> and <strong>' + getOld + "</strong>";
                    } else {
                        html += '<strong> You liked</strong>';
                    }
                    showLikeElement.empty();
                    showLikeElement.html(html);
                    // Cập nhật avt người like
                    var img = `<img src="${avatarUserCurrent}" alt="" class="w-6 h-6 rounded-full border-2 border-white dark:border-gray-900">`;
                    avatarUserLike.children().last().remove();
                    avatarUserLike.prepend(img);

                    // Send notification
                    if (userID != authorID) {
                        SaveNotification(postID, 'like');
                        SendNotification(postID, "like");
                    }
                } else {
                    likeIcon.attr("fill", "currentColor");
                    likeText.css("color", "#666666");
                    // Cập nhật lượt like => Unlike
                    var quantityLike = likeText.find("span");
                    var currentLikes = parseInt(quantityLike.text().replace(/\D/g, ''), 10);
                    if (!isNaN(currentLikes)) {
                        // Tăng giá trị lên 1 và cập nhật lại nội dung của thẻ <span>
                        var newLikes = currentLikes - 1;
                        quantityLike.text("(" + newLikes + ")");
                    }
                    var getOld = showLikeElement.text();
                    var html = "";
                    if (getOld.trim() != "You liked") {
                        html += '<strong>' + getOld.match(/(\d+)\s*others/)[1] + " others</strong>";
                    }
                    showLikeElement.empty();
                    showLikeElement.html(html);
                    // Cập nhật avt người like
                    avatarUserLike.children().first().remove();
                }
            }
        }
    })
});


//share post
$(document).on('click', '.share-post-btn', function (e) {
    e.preventDefault();
    // Show modal share details when click share
    // Reset modal
    $("#share-post-modal .share-details-card").empty();
    var postID = $(this).parent().attr("post-id");
    var postCardHTML = $(`.post-card[post-id=${postID}]`)[0].outerHTML;
    $("#share-post-modal .share-details-card").html(postCardHTML);
    $(`#share-post-modal .share-details-card .post-card`).find('.space-y-3').remove();
    $("#share-post-modal").removeAttr("style");
    var userID = $("input[name='txtUserid']").val();
    $(".btn-share-post").click(function (event) {
        event.preventDefault();
        var privacy = $("#share-post-modal").find(".dropdown-toggle .filter-option").text();
        var taPostShare = $("textarea[name='taPostShare']").val();
        var data = {
            privacy: privacy,
            tapostshare: taPostShare,
            userid: userID,
            postid: postID,
            action: "share-post"
        };
        console.log(data);
        $.ajax({
            url: "Ajax/Post.php",
            type: "POST",
            data: data,
            success: function (response) {
                if (response) {
                    if (response.trim() == "1") {
                        showNotification("Share post successfully.")
                        $("#share-post-modal #closeModelPost ").click()
                        SaveNotification(postID, "share");
                        SendNotification(postID, "share");
                    }
                }
            }
        })
    })

});

// Show modal post details when click comment
$(document).on('click', '.comment-post-btn', function (e) {
    e.preventDefault();
    // Reset modal
    $("#post-details-modal .post-details-card").empty();
    var postID = $(this).attr("post-id");
    var userOfPost = $(`.post-card[post-id=${postID}]:eq(0)`).find("a.text-black").text();
    $("#post-details-modal h3").text(userOfPost + "'s post");
    var postCardHTML = $(`.post-card[post-id=${postID}]`)[0].outerHTML;
    $("#post-details-modal .post-details-card").html(postCardHTML);
    $("#post-details-modal .comment-textbox").focus();
});

// Add comment 
// Event phim enter
$(document).on("keyup", ".comment-textbox", function (e) {
    if (e.which === 13 && !e.shiftKey) {
        var userID = $("input[name='txtUserid']").val();
        var postID = $(this).attr('post-id');
        // Sua thanh 
        var msg = $(this).val();
        msg = escapeHtml(msg);
        if (msg.trim().length == 0) {
            showNotification("Please enter text to comment!")
        } else {
            CreateComment(userID, postID, msg);
        }
    }
})
// Event click vao nut gui comment
$(document).on("click", ".add-comment-btn", function (e) {
    e.preventDefault;
    var userID = $("input[name='txtUserid']").val();
    var postID = $(this).attr('post-id');
    var msg = $(this).parent().prev().val();
    msg = escapeHtml(msg);
    if (msg.trim().length == 0) {
        showNotification("Please enter text to comment!")
    } else {
        CreateComment(userID, postID, msg);
    }

});
function CreateComment(userID, postID, msg) {
    $.ajax({
        url: "Ajax/Post.php",
        method: "POST",
        data: {
            msg: msg,
            userID: userID,
            postID: postID,
            action: "add-comment"
        },
        success: function (response) {
            $(".comment-container[post-id='" + postID + "']").html("");
            var commentData = JSON.parse(response);
            console.log(commentData);
            $.each(commentData, function (key, value) {
                var time = timeAgo(value.cmt["date"]);
                $(".comment-container[post-id='" + postID + "']").append('<div class="flex">\
                        <div class="w-10 h-10 rounded-full relative flex-shrink-0">\
                            <a href="profile.php?uid='+ value.user.userid + '">\
                            <img src="'+ value.user["avatar_image"] + '" alt="" class="absolute h-full rounded-full w-full">\
                            </a>\
                        </div>\
                        <div>\
                            <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">\
                                <a href="profile.php?uid='+ value.user.userid + '">\
                                    <b>'+ value.user["first_name"] + ' ' + value.user["last_name"] + '</b>\
                                </a>\
                                <p class="leading-6">'+ value.cmt["comment_msg"] + '</p>\
                                <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>\
                            </div>\
                            <div class="text-sm flex items-center space-x-3 mt-2 ml-5">\
                                <button class="reply-option-btn" commentid="'+ value.cmt.comment_id + '">Reply</button>\
                                <button class="view-reply-btn ml-8 mt-0" commentid="'+ value.cmt.comment_id + '" style="font-size: 13px;" data-next-offset="0">View replies (' + value.totalrep + ')</button>\
                                <span>'+ time + '</span>\
                            </div>\
                            <div class="reply-dropdown bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" commentid="'+ value.cmt.comment_id + '" style="display: none;">\
                                <input placeholder="Reply '+ value.user.last_name + '" class="bg-transparent max-h-10 shadow-none px-5 reply-comment-textbox" post-id="' + postID + '">\
                                   <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">\
                                       <button style="padding: 6px;" href="#" class="reply-comment-btn" commentid="'+ value.cmt.comment_id + '" post-id="' + postID + '">\
                                           <ion-icon name="arrow-redo-outline"></ion-icon>\
                                       </button>\
                                   </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="reply-comment-msg " commentid="'+ value.cmt.comment_id + '">\
                    </div>'
                );
            });
            $(".comment-textbox[post-id='" + postID + "']").val("");
            $("#post-details-modal #quantity-comment").text(`Comment (${commentData[0].totalComment})`);
            $("#post-details-modal .count-cmt").text(`2/${commentData[0].totalComment}`);
            SaveNotification(postID, "comment");
            SendNotification(postID, "comment");
        }
    });
}
// View more comment
$(document).on("click", ".btn-view-more-comment", function (e) {
    e.preventDefault();
    var postID = $(this).prev().attr("post-id");
    var offset = $(this).data("next-offset");
    var addCommentButton = $(this);
    var btnShow = addCommentButton.prev().prev().prev().find(".comment-post-btn")[0];
    if ($("#post-details-modal").hasClass("uk-open")) {
        ViewMoreComment();
    } else {
        btnShow.click();
        ViewMoreComment();
    }
    function ViewMoreComment() {
        $.ajax({
            url: "Ajax/Post.php",
            type: "POST",
            data: {
                postid: postID,
                offset: offset,
                action: "view-more-comment"
            },
            success: function (response) {
                if (response.trim() != "[]" && response.trim() != "0") {
                    var cmtData = JSON.parse(response);
                    console.log(cmtData);
                    $.each(cmtData, function (key, value) {
                        var time = timeAgo(value.cmt["date"]);
                        $("#post-details-modal .comment-container").append('<div class="flex">\
                        <div class="w-10 h-10 rounded-full relative flex-shrink-0">\
                            <a href="profile.php?uid='+ value.user.userid + '">\
                            <img src="'+ value.user["avatar_image"] + '" alt="" class="absolute h-full rounded-full w-full">\
                            </a>\
                        </div>\
                        <div>\
                            <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">\
                                <a href="profile.php?uid='+ value.user.userid + '">\
                                    <b>'+ value.user["first_name"] + ' ' + value.user["last_name"] + '</b>\
                                </a>\
                                <p class="leading-6">'+ value.cmt["comment_msg"] + '</p>\
                                <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>\
                            </div>\
                            <div class="text-sm flex items-center space-x-3 mt-2 ml-5">\
                                <button class="reply-option-btn" commentid="'+ value.cmt.comment_id + '">Reply</button>\
                                <button class="view-reply-btn ml-8 mt-0" commentid="'+ value.cmt.comment_id + '" style="font-size: 13px;" data-next-offset="0">View replies (' + value.totalrep + ')</button>\
                                <span>'+ time + '</span>\
                            </div>\
                            <div class="bg-gray-100 rounded-full relative dark:bg-gray-800 border-t" commentid="'+ value.cmt.comment_id + '" style="display: none;">\
                                <input placeholder="Reply '+ value.user.last_name + '" class="bg-transparent max-h-10 shadow-none px-5 reply-comment-textbox" post-id="' + postID + '">\
                                   <div class="-m-0.5 absolute bottom-0 flex items-center right-3 text-xl">\
                                       <button style="padding: 6px;" href="#" class="reply-comment-btn"commentid="'+ value.cmt.comment_id + '" post-id="' + postID + '">\
                                           <ion-icon name="arrow-redo-outline"></ion-icon>\
                                       </button>\
                                   </div>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="reply-comment-msg " commentid="'+ value.cmt.comment_id + '">\
                    </div>'
                        );
                    });
                    // Offset tiep theo = offset ban dau (2) + so luong ban ghi (20) | (#NextOffset = So comment dang duoc hien thi ra)
                    var nextOffet = offset + 20;
                    if (nextOffet > cmtData[0].totalComment) nextOffet = cmtData[0].totalComment;
                    // Hien thi "View more xxx comment" | xxx = TongSoCmt cua bai post - next offset | (#remainingQuantity = So comment con lai chua hien thi)
                    var remainingQuantity = cmtData[0].totalComment - nextOffet;
                    $("#post-details-modal .btn-view-more-comment").data("next-offset", nextOffet);
                    $("#post-details-modal .btn-view-more-comment").text(`View more ${remainingQuantity} Comments `)
                    $("#post-details-modal .count-cmt").remove();
                    $("#post-details-modal .btn-view-more-comment").after(`<span class="count-cmt" style="margin-left: 68%">${nextOffet}/${cmtData[0].totalComment}</span>`);
                    if (remainingQuantity <= 0) {
                        $("#post-details-modal .btn-view-more-comment").hide();
                        $("#post-details-modal .count-cmt").css("margin-left", "90%");
                    }

                }
            }
        })
    }
})
// Reply comment
// Su kien click reply -> hien ra o input
$(document).on("click", ".reply-option-btn", function (e) {
    var inputReply = $(this).parent().next();
    if (inputReply.css("display") == "none") {
        inputReply.show();
        inputReply.find("input").focus();
    } else inputReply.hide();
})
// add reply
//rep an bieu tuong
$(document).on('click', '.reply-comment-btn', function (e) {
    e.preventDefault;
    var userID = $("input[name='txtUserid']").val();
    var commentID = $(this).attr("commentid");
    var postID = $(this).attr("post-id");
    //var msg = $(".reply-dropdown[commentid='" + commentID + "'] input").val();
    var msg = $(this).parent().prev().val();
    console.log(msg)
    if (msg.trim().length == 0) {
        showNotification("Please enter text to reply comment!")
    } else {
        $("#post-details-modal .view-reply-btn[commentid='" + commentID + "']").data("next-offset", 0);
        createReplyComment(commentID, postID, userID, msg);
    }
});
//rep nhan enter
$(document).on("keyup", ".reply-comment-textbox", function (e) {
    e.preventDefault;
    if (e.which === 13 && !e.shiftKey) {
        var userID = $("input[name='txtUserid']").val();
        var postID = $(this).attr('post-id');
        var commentID = $(this).parent().attr('commentid');
        var msg = $(this).val();
        console.log(msg);
        if (msg.trim().length == 0) {
            showNotification("Please enter text to comment!")
        } else {
            $("#post-details-modal .view-reply-btn[commentid='" + commentID + "']").data("next-offset", 0);
            createReplyComment(commentID, postID, userID, msg);
        }
    }
})
function createReplyComment(commentID, postID, userID, msg) {
    $.ajax({
        url: "Ajax/Post.php",
        method: "POST",
        dataType: "html",
        data: {
            msg: msg,
            userID: userID,
            commentID: commentID,
            postID: postID,
            action: "add-reply-comment"
        },
        success: function (response) {
            $(".reply-comment-msg[commentid='" + commentID + "']").html("");
            $(".reply-dropdown[commentid='" + commentID + "']").hide();
            var commentData = JSON.parse(response);
            console.log(commentData);
            $.each(commentData, function (key, value) {
                $(".view-reply-btn[commentid='" + commentID + "']").text("View replies (" + value.totalCommentr + ")");
                var time = timeAgo(value.cmt["date"]);
                $(".reply-comment-msg[commentid='" + commentID + "']").append('<div class="flex" >\
                <div class="w-10 h-10 rounded-full relative flex-shrink-0 ml-8">\
                    <a href="profile.php?uid='+ value.user.userID + '">\
                        <img src="'+ value.user["avatar_image"] + '" alt="" class="absolute h-full rounded-full w-full">\
                    </a>\
                </div>\
                <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">\
                        <a href="profile.php?uid='+ value.user.userID + '"><b>' + value.user["first_name"] + ' ' + value.user["last_name"] + '</b></a>\
                        <span style="font-size: 13;">'+ time + '</span>\
                        <p class="leading-6">'+ value.cmt["comment_msg"] + '</p>\
                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>\
                </div>\
            </div>'
                );
            });
            $(".reply-comment-textbox[post-id='" + postID + "']").val("");
        }
    });
}
//view reply comment
$(document).on("click", ".view-reply-btn", function (e) {
    e.preventDefault;
    var commentid = $(this).attr("commentid");
    var offset = $(this).data("next-offset");
    var btnShow = $(this).closest('.comment-container').siblings().find('.comment-post-btn')[0];
    if ($("#post-details-modal").hasClass("uk-open")) {
        ViewMoreRepComment();
    } else {
        btnShow.click();
        ViewMoreRepComment();
    }
    function ViewMoreRepComment() {
        $.ajax({
            url: "Ajax/Post.php",
            type: "POST",
            data: {
                commentid: commentid,
                offset: offset,
                action: "view-more-reply-comment"
            },
            success: function (response) {
                if (response.trim() != "[]" && response.trim() != "0") {
                    var cmtData = JSON.parse(response);
                    console.log(cmtData);
                    if (offset == 0) $(".reply-comment-msg[commentid='" + commentid + "']").html("");
                    $.each(cmtData, function (key, value) {
                        var time = timeAgo(value.cmt["date"]);
                        $("#post-details-modal .view-reply-btn").data("next-offset", nextOffet);
                        $("#post-details-modal .reply-comment-msg[commentid='" + commentid + "']").append('<br>\
                            <div class="flex" >\
                                <div class="w-10 h-10 rounded-full relative flex-shrink-0 ml-8">\
                                    <a href="profile.php?uid='+ value.user["userid"] + '">\
                                        <img src="'+ value.user["avatar_image"] + '" alt="" class="absolute h-full rounded-full w-full">\
                                    </a>\
                                </div>\
                                <div class="text-gray-700 py-2 px-3 rounded-md bg-gray-100 relative lg:ml-5 ml-2 lg:mr-12  dark:bg-gray-800 dark:text-gray-100">\
                                        <a href="profile.php?uid='+ value.user["userid"] + '"><b>' + value.user["first_name"] + ' ' + value.user["last_name"] + '</b></a>\
                                        <span style="font-size: 13;">'+ time + '</span>\
                                        <p class="leading-6">'+ value.cmt["comment_msg"] + '</p>\
                                        <div class="absolute w-3 h-3 top-3 -left-1 bg-gray-100 transform rotate-45 dark:bg-gray-800"></div>\
                                </div>\
                            </div>'
                        );
                    });
                    var nextOffet = offset + 20;
                    if (nextOffet > cmtData[0].totalComment) nextOffet = cmtData[0].totalComment;
                    var remainingQuantity = cmtData[0].totalComment - nextOffet;
                    $("#post-details-modal .view-reply-btn[commentid='" + commentid + "']").data("next-offset", nextOffet);
                    $("#post-details-modal .view-reply-btn[commentid='" + commentid + "']").next().attr('commentid', commentid);
                    $("#post-details-modal .view-reply-btn[commentid='" + commentid + "']").text(`View replies (${remainingQuantity})`)
                    $("#post-details-modal .count-cmtr").remove();
                    $("#post-details-modal .view-reply-btn[commentid='" + commentid + "']").after(`<span class="count-cmtr" >${nextOffet}/${cmtData[0].totalComment}</span>`);
                    // if (remainingQuantity <= 0) {
                    //     $("#post-details-modal .view-reply-btn[commentid='"+commentid+"']").hide();
                    // }

                }
            }
        })
    }

});

// Delete post
function deletePost(event, btn) {
    event.preventDefault();
    var postid = btn.getAttribute("data-post-id");
    var media = [];
    var image = $(".card[post-id='" + postid + "']").find("div[uk-lightbox] img");
    image.each(function (index, item) {
        var fileName = $(item).attr('src');
        fileName = fileName.match(/([^\/?#]+)$/);
        if (media.indexOf(fileName[1]) === -1) {
            media.push(fileName[1]);
        }
    });
    var video = $(".card[post-id='" + postid + "']").find("div[uk-lightbox] video");
    video.each(function (index, item) {
        var fileName = $(item).find('source').attr('src');
        fileName = fileName.match(/([^\/?#]+)$/);
        if (media.indexOf(fileName[1]) === -1) {
            media.push(fileName[1]);
        }
    });
    // console.log(media);

    if (confirm("Are you sure want to delete this post?")) {
        $.ajax({
            url: "Ajax/Post.php",
            type: "POST",
            data: {
                postid: postid,
                action: "delete-post"
            },
            success: function (response) {
                if (response.trim() == 1) {
                    showNotification("Delete successfully");
                    var postCard = document.querySelector(`.card[post-id="${postid}"]`);
                    postCard.remove();
                    DeleteFilesFromServer(media);
                }
            }
        })
    }
}

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

function timeAgo(dateString) {
    const currentDate = new Date();
    const pastDate = new Date(dateString);
    const timeDifference = currentDate - pastDate;
    const seconds = Math.floor(timeDifference / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);

    if (days > 0) {
        return days + " ngày trước";
    } else if (hours > 0) {
        return hours + " giờ trước";
    } else if (minutes > 0) {
        return minutes + " phút trước";
    } else {
        return "vài giây trước";
    }
}

