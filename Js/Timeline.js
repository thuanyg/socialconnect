// View next post
var userID = $("input[name='txtUserid']").val();
var windowHeight = window.innerHeight;
var scrolledOnce = false;
var postFetching = false; // Sửa thành postFetching
var offset = 5;
var postDocument = $("#PostContaier");
var shouldLoadMore = true;

$(window).scroll(function() {
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
        success: function(data) {
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
$(".friend-tab").on("click", function(e) {
    e.preventDefault();
    $(".friend-tab").removeClass("active"); 
    $(this).addClass("active");
    if($(this).index() == 1){ // Tab recently
        $(".tab").hide();
        $(".recently-friend-tab").show();
    }
    if($(this).index() == 0){ // Tab friend
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




$("#about-save-btn").click(function(e) {
    // e.preventDefault();
    if (confirm("Do you want to change about?")) {
        var userid = $(".data-userid")[0].textContent;
        var birthday = $("input[name='dBirthday']").val();
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
            success: function(data) {
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
//tải ảnh lên server
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
    var imagesNew = await UploadFilesToServer(formImages);
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
                
                window.location.href='timeline.php';
            }
        }
    })
    
})


$(".save-edit-cover").on('click', async function (e) {
    e.preventDefault();
    
    var formImages = $("form[name='fanhcover']");
    var userid = $("input[name='userid']").val();
    var imagesNew = await UploadFilesToServer(formImages);
    console.log(imagesNew)
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
                
                window.location.href='timeline.php';
            }
        }
    })
    
})
