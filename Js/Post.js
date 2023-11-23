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
        try {
            var response = await $.ajax({
                url: "Ajax/Upload.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false
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

    // if (fileInput.files.length == 0) {
    //     if (post.trim().length == 0) {
    //         showNotification("Hãy nhập nội dung bài viết");
    //         isValid = false;
    //     }
    // }
    if (post.length > 1000) {
        showNotification("Bài viết của bạn quá dài. Hãy kiểm tra lại");
        isValid = false;
    }
    try {
        if (isValid) {
            var formImages = $("form[name='upload-image']");
            var formVideos = $("form[name='upload-video']");
            var images = await UploadFilesToServer(formImages);
            var videos = await UploadFilesToServer(formVideos);
            var media = images.concat(videos);
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
                    if (data) {
                        showNotification("You have successfully posted the article");
                        var PostContaier = document.getElementById('PostContaier');
                        PostContaier.firstElementChild.insertAdjacentHTML('afterend', data);
                        $("#closeModelPost").click();
                    } else {
                        showNotification("Something wrong!");
                    }
                }
            });
        }
    } catch (error) {
        console.error(error);
    }
}


// Edit post
// var oldImages = [];
var filesAfter = [];
var filesDeleted = [];
$(".post-action .post-action-edit").on("click", function (e) {
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
                var optionElement = editPostModal.find(".Privacy select option").filter(function() {
                    return $(this).text() === post.privacy;
                });
                if(post.privacy == "Public"){
                    editPostModal.find(".Privacy .dropdown-menu li").removeClass("selected")
                    editPostModal.find(".Privacy .dropdown-menu li:eq(0)").addClass("selected")
                }
                if(post.privacy == "Friend"){
                    editPostModal.find(".Privacy .dropdown-menu li").removeClass("selected")
                    editPostModal.find(".Privacy .dropdown-menu li:eq(1)").addClass("selected")
                }
                if(post.privacy == "Private"){
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
        // console.log("Ảnh cũ sau khi xóa: " + filesAfter);
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
// Like post
$(".like-post-btn").on("click", function (e) {
    var userID = $("input[name='txtUserid']").val();
    e.preventDefault();
    var postID = $(this).parent().attr("post-id");
    // console.log(userID + " " + postID);
    var notify = {
        userid: userID,
        postid: postID,
        action: "like-post"
    };
    ws.send(JSON.stringify(notify));
});
// Delete post
function deletePost(event, btn) {
    event.preventDefault();
    var postid = btn.getAttribute("data-post-id");
    var media = [];
    var image = $(".card[post-id='" + postid + "']").find("div[uk-lightbox] img");
    image.each(function(index, item) {
        var fileName = $(item).attr('src');
        fileName = fileName.match(/([^\/?#]+)$/);
        if (media.indexOf(fileName[1]) === -1) {
            media.push(fileName[1]);
        }
    });
    var video = $(".card[post-id='" + postid + "']").find("div[uk-lightbox] video");
    video.each(function(index, item) {
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
                if (response == 1) {
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

