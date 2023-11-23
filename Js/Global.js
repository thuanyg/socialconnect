
// Search users - Ajax
$("input[name='txtSearch']").on("input", function () {
    var query = $(this).val();
    Search(query);
});

$("input[name='txtSearch']").keyup(function (e) {
    if (e.which === 13) {
        var query = $(this).val();
        SearchFriend(query);
        SearchPost(query);
    }
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