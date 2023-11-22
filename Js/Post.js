// Click nút thêm ảnh khi đăng/sửa bài viết
// Áp dụng modal create post
$(".btn-input-image").click(function () {
    var _html = '<li><span onclick="DelImg(this)" style="display: none; cursor: pointer">×</span>'
    _html += '<form method="POST" name="upload-image" enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadImg(this)" /></form></li>';
    $('#imagePreview ul').append(_html);
    $('#imagePreview ul li').last().find('input[type="file"]').click();
})
// Áp dụng modal edit post
$(".btn-input-edit-image").click(function () {
    var _html = '<li><span onclick="DelImg(this)" style="display: none; cursor: pointer">×</span>'
    _html += '<form method="POST" name="upload-edit-image" enctype="multipart/form-data">'
    _html += '<input type="file" name="fileToUpload[]" multiple hidden onchange="uploadEditImg(this)" /></form></li>';
    $('#imageEditPreview ul').append(_html);
    $('#imageEditPreview ul li').last().find('input[type="file"]').click();
})
// Show ảnh preview 
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
async function UploadImageToServer(listForm) {
    var images = [];
    // var formImages = $("form[name='upload-image']");
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
            var image = JSON.parse(response);
            images = images.concat(image);
        } catch (error) {
            console.error("Error uploading image:", error);
        }
    }
    return images;
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
            var images = await UploadImageToServer(formImages);
            // console.log(images);
            $.ajax({
                url: "Ajax/Post.php",
                method: "POST",
                dataType: "html",
                data: {
                    post: post,
                    userid: userid,
                    images: images,
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
                        showNotification("Somthing wrong!");
                    }
                }
            });
        }
    } catch (error) {
        console.error(error);
    }
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
// Edit post
var oldImages = [];
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
                var media = JSON.parse(post.media)
                oldImages = media;
                console.log(media);
                for (var i = 0; i < media.length; i++) {
                    var img = document.createElement('img');
                    img.src = './uploads/posts/' + media[i];
                    img.style.display = 'inline-block';
                    img.style.maxWidth = '200px';
                    img.style.maxHeight = '200px';
                    var li = document.createElement('li');
                    li.innerHTML = '<span onclick="DeleteOldImage(this)" style="cursor: pointer">×</span>';
                    li.appendChild(img)
                    imagePreview.append(li);
                }
            }
        }
    })

    $(".save-edit-post").on('click',async function (e) {
        e.preventDefault();
        var postText = editPostModal.find("textarea").val();
        var privacy = editPostModal.find(".dropdown-toggle .filter-option").text();
        var isValid = true;
        if (postText.length > 1000) {
            showNotification("Bài viết của bạn quá dài. Hãy kiểm tra lại");
            isValid = false;
        }
        try {
            if (isValid) {
                var formImages = $("form[name='upload-edit-image']");
                var images = await UploadImageToServer(formImages);
                console.log(images);
                $.ajax({
                    url: "Ajax/Post.php",
                    type: "POST",
                    data: {
                        postText: postText,
                        privacy: privacy,
                        postId: postID,
                        images: images,
                        action: "edit-post"
                    },
                    success: function (response) {
                        // window.location.href = "feed.php";
                    }
                })
            }
        } catch (error) {
            console.error(error);
        }
    })
})
// Delete old image when edit post
function DeleteOldImage(btn) {
    var srcImage = btn.nextSibling.src;
    var fileName = srcImage.match(/([^\/?#]+)$/);
    btn.parentElement.remove();
    if (fileName && fileName[1]) {
        // console.log('Tên file:', fileName[1]);
        var myArray = oldImages.filter(function (item) {
            return item !== fileName[1];
        });
        return myArray;
    }
}
// Delete post
function deletePost(event, btn) {
    event.preventDefault();
    var postid = btn.getAttribute("data-post-id");
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
                    var postCard = document.querySelector(`[post-id="${postid}"]`);
                    postCard.remove();
                }
            }
        })
    }
}

