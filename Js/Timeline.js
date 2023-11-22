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

// Delete post
function DeletePost(e, btn) {
    e.preventDefault();
    if (confirm("Do you want to delete this post?")) {
        var postid = btn.getAttribute("data-postid");
        showNotification("Processing...");
        $.ajax({
            url: "Ajax/Post.php",
            method: "POST",
            dataType: "html",
            data: {
                postid: postid,
                action: "delete-post"
            },
            success: function(data) {
                if (data == 1) {
                    showNotification("You have successfully delete this post");
                    window.location.href = "timeline.php"
                } else {
                    showNotification("Something wrong!");
                }
            }
        });
    }
}



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
// Search users - Ajax
$("input[name='txtSearch']").on("input", function() {
    var query = $(this).val();
    Search(query);
    // console.log(query);
});

function Search(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-user"
        },
        success: function(data) {
            if (data) {
                $(".header_search_dropdown").addClass("uk-open");
                $("#searchResults").html(data);
            }
        },
    });
}