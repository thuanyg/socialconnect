// View next post
var userID = $("input[name='txtUserid']").val();
var windowHeight = window.innerHeight;
var scrolledOnce = false;
var postFetching = false;
var offset = 5;
var postDocument = $("#PostContaier");
var shouldLoadMore = true;
var filesAfter = [];
var filesDeleted = [];
$(window).scroll(function () {
    if (shouldLoadMore) {
        var docHeight = postDocument.height();
        var scrollTop = $(this).scrollTop();

        if (!postFetching && scrollTop + windowHeight > docHeight - 800 && !scrolledOnce) {
            scrolledOnce = true;
            ViewNextPost();
        } else {
            scrolledOnce = false;
        }
    }
});

function getPostToLoad(userid, offset) {
    postFetching = true;
    $.ajax({
        url: "Ajax/Post.php",
        type: "POST",
        data: {
            userid: userid,
            offset: offset,
            action: "get-post-timeline-to-load"
        },
        cache: false,
        success: function (data) {
            postFetching = false;
            if (data.trim()) {
                postDocument.append(data);
                if (data.trim() == '<div style="text-align: center">Không còn bài viết</div>') {
                    shouldLoadMore = false;
                    console.log("End of the posts");
                }
            } else {
                shouldLoadMore = false;
                return;
            }
        },
    });
}
function ViewNextPost() {
    // console.log("Calling ViewNextPost");
    if (postFetching) return;
    getPostToLoad(userID, offset);
    offset += 5;
}
// Click the tabs
$(".friend-tab").on("click", function (e) {
    e.preventDefault();
    $(".friend-tab").removeClass("active");
    $(this).addClass("active");
    if ($(this).index() == 1) { // Tab recently
        $(".tab").hide();
        $(".recently-friend-tab").show();
    }
    if ($(this).index() == 0) { // Tab friend
        $(".tab").hide();
        $(".all-friend-tab").show();
    }
    // if($(this).index() == 2){ // Tab family
    //     $(".tab").hide();
    //     $(".recently-friend-tab").show();
    // }
    // if($(this).index() == 3){ // Tab University
    //     $(".tab").hide();
    //     $(".recently-friend-tab").show();
    // }
});



//Photo of you
function showImageOfYou() {
    var num = 0;
    var userid = $("input[name='txtUserid']").val();
    console.log(userid);
    $.ajax({
        url: "Ajax/Post.php",
        method: "POST",
        dataType: "html",
        data: {
            userid: userid,
            num : num,
            action: "show-image-of-you"
        },
        success: function (data) {
            //console.log(data);
            $("#result").html(data);
            fnPhotoOfYou();

            var number = 0;
            $(".btn-load-more-photo").on("click", function (e) {
                e.preventDefault();
                number += 8;
                var userid = $("input[name='txtUserid']").val();
                $.ajax({
                    url: "Ajax/Post.php",
                    method: "POST",
                    dataType: "html",           
                    data: {
                        userid: userid,
                        number : number,
                        action: "show-more-image-of-you"
                    },
                    success: function (data) {
                        //console.log(data);
                        $("#result .load-more").before(data);
                        fnPhotoOfYou();
                    }
                })
            });
        }
    });
}
function fnPhotoOfYou() {
    // Photo tab
    $(".photo-tab").on("click", function (e) {
        e.preventDefault();
        $(".photo-tab").removeClass("active");
        $(this).addClass('active');
        if ($(this).hasClass("album")) {
            $(".photo-of-you").hide();
            $(".album-of-you").show();
        } else {
            $(".album-of-you").hide();
            $(".photo-of-you").show();
        }

    });
    //Phôt click to big
    $(document).ready(function () {
        $('.image-small img').on('click', function () {
            var imgUrl = $(this).attr('src');
            $('.image-big img').attr('src', imgUrl);
            $('.image-big').css({ "display": "block", "opacity": "1", "align-items": "center" });
        });

        //dong anh lon
        $('.image-big .close-image').on('click', function () {
            $('.image-big').css({ "display": "none", "opacity": "0" });
        });
    });
}

$("#about-save-btn").click(function (e) {
    // e.preventDefault();
    if (confirm("Do you want to change about?")) {
        var userid = $(".data-userid")[0].textContent;
        var birthday = $("input[name='dBirthday']").val();
        var birthdayDate = new Date(birthday);
        var currentDate = new Date();
        if(birthdayDate > currentDate){
            showNotification("Ngày sinh không hợp lệ");
            return;
        }
        var address = $("input[name='txtAddress']").val();
        var education = $("input[name='txtEducation']").val();
        var desc = $("textarea[name='taBio']").val();
        showNotification("Processing...");
        $.ajax({
            url: "Ajax/User.php",
            method: "POST",
            dataType: "html",
            data: {
                userid: userid,
                birthday: birthday,
                address: address,
                education: education,
                desc: desc,
                action: "add-about"
            },
            success: function (data) {
                if (data == 1) {
                    showNotification("You have successfully added about");
                    window.location.href = "timeline.php"
                } else {
                    showNotification("Something wrong!");
                }
            }
        });
    }
});
//input upload avatar
function uploadImgAvatar(el) {
    $('#imagePreview ul ').empty();
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
                $('#imagePreview ul ').append(newImage.outerHTML);
                // $('#imagePreview ul span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp hình ảnh có kích thước tối đa 5MB.');
        }
    }
}

function uploadEditImgAbout(el) {
    var file_data = $(el).prop('files');
    //$('#imageAboutPreview ul ').empty();

    //console.log(file_data)
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
                var li = document.createElement('li');
                li.innerHTML = '<span onclick="DeleteOldFiles(this)" style="cursor: pointer" title="Delete">×</span>';

                $('#imageAboutPreview ul').append(li);
                $('#imageAboutPreview ul li:last').append(newImage.outerHTML);

                $('#imageAboutPreview ul li:last span').show();
            }
            fileReader.readAsDataURL(fileToLoad);
        } else {
            showNotification('Hãy chọn một tệp hình ảnh có kích thước tối đa 5MB.');
            $('#imageAboutPreview ul li').last().remove();
        }
    }
}
//tải ảnh lên server
async function UploadToServer(listForm) {
    var files = [];
    // var formfiles = $("form[name='upload-image']");
    for (let i = 0; i < listForm.length; i++) {
        var formData = new FormData(listForm[i]);
        formData.append('action', 'upload-file-user');
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
//tải ảnh about lên server
async function UploadAboutImgToServer(listForm) {
    var files = [];
    // var formfiles = $("form[name='upload-image']");
    for (let i = 0; i < listForm.length; i++) {
        var formData = new FormData(listForm[i]);
        formData.append('action', 'upload-file-about');
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


$(".save-edit-avatar").on('click', async function (e) {
    e.preventDefault();

    var formImages = $("form[name='fanh']");
    var userid = $("input[name='userid']").val();
    var imagesNew = await UploadToServer(formImages);
    //console.log(imagesNew)
    $.ajax({
        url: "Ajax/User.php",
        type: "POST",
        data: {
            userid: userid,
            imagesNew: imagesNew[0],
            action: "save-edit-avatar"
        },
        success: function (response) {
            if (response) {

                window.location.href = 'timeline.php';
            }
        }
    })

})


$(".save-edit-cover").on('click', async function (e) {
    e.preventDefault();

    var formImages = $("form[name='fanhcover']");
    var userid = $("input[name='userid']").val();
    var imagesNew = await UploadToServer(formImages);

    //console.log(imagesNew)
    $.ajax({
        url: "Ajax/User.php",
        type: "POST",
        data: {
            userid: userid,
            imagesNew: imagesNew[0],
            action: "save-edit-cover"
        },
        success: function (response) {
            if (response) {

                window.location.href = 'timeline.php';
            }
        }
    })

})

$('.btn-edit-about-image').on('click', function (e) {
    e.preventDefault();
    var userid = $("input[name='userid']").val();
    var imagePreview = $('#imageAboutPreview ul');
    $.ajax({
        url: "Ajax/User.php",
        type: "POST",
        data: {
            userid: userid,
            action: "show-about-image",
        },
        success: function (data) {
            $('#imageAboutPreview ul ').empty();
            var data = JSON.parse(data);
            //console.log(data);
            var media = JSON.parse(data[0].about_image);
            filesAfter = media;
            for (var i = 0; i < media.length; i++) {
                var img = document.createElement('img');
                img.src = './uploads/avatars/' + media[i];
                img.style.display = 'inline-block';
                img.style.maxWidth = '200px';
                img.style.maxHeight = '200px';
                var li = document.createElement('li');
                li.innerHTML = '<span onclick="DeleteOldFiles(this)" style="cursor: pointer" title="Delete">×</span>';
                li.appendChild(img)
                imagePreview.append(li);
            }
        }
    })
})

$(".save-edit-about-image").on('click', async function (e) {
    e.preventDefault();
    
    var formImages = $("form[name='fanhAbout']");
    var imagesNew = await UploadAboutImgToServer(formImages);
    var media = imagesNew.concat(filesAfter);
    
    if (media.length <= 4) {
        //console.log(media)
        $.ajax({
            url: "Ajax/User.php",
            type: "POST",
            data: {
                userid: userID,
                media: media,
                action: "save-edit-about-image"
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
    } else {
        $(".closeModal").click();
        showNotification("Chỉ được chọn tối đa 4 ảnh!");
        DeleteFilesFromServer(imagesNew);
    }

})


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
$(".see-all-btn").on('click', function (e) {
    e.preventDefault();
    $.ajax({
        url: "Ajax/Friend.php",
        type: "POST",
        data: {
            userid: userID,
            action: "see-all-btn"
        },
        success: function (response) {
            $(".show-friend").html(response);
        }
    })
})
// Delete account
$(".delete-account-btn").on('click', function (e) {
    e.preventDefault();
    if (confirm("Bạn chắc chắn muốn xóa tài khoản này? Chúng tôi sẽ xóa vĩnh viễn và bạn sẽ không thể phục hồi")) {
        $.ajax({
            url: "Ajax/User.php",
            type: "POST",
            data: {
                userid: userID,
                action: "delete-account"
            },
            success: function (response){
                if(response.trim() == 1){
                    window.location.href = "login.php"
                }
            }
        })
    }
})

