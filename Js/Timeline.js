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

// Search users - Ajax
$("input[name='txtSearch']").on("input", function () {
    var query = $(this).val();
    Search(query);
    // console.log(query);
});

$("input[name='txtSearch']").keyup(function (e) {
    if (e.which === 13) {
        var query = $(this).val();
        SearchFriend(query);
        SearchPost(query);
    }

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
        success: function (data) {
            if (data) {
                $(".header_search_dropdown").addClass("uk-open");
                $("#searchResults").html(data);
            }
        },
    });
}
function SearchFriend(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-friend"
        }, 
        success: function(data){
            if(data){
                localStorage.setItem("myData", JSON.stringify(data));
                window.location.href="search-post.php";
               //console.log(data)
            }
        }
    })
}
function SearchPost(query){
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-post"
        },
        success: function(postSearchData){
            if(postSearchData){
                localStorage.setItem("postSearchData", JSON.stringify(postSearchData));
                window.location.href="search-post.php";
                //console.log(postSearchData)
            }
        }
    })
}