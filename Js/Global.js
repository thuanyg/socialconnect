
// Search users - Ajax
var searchDocument = $("#searchResults");
var scrolledOnce = false;
var searchFetching = false;
var offset = 10;
var shouldLoadMore = true;
$("input[name='txtSearch']").on("input", function () {
    var query = $(this).val();
    $("#searchResults > :not(#search-loading)").remove();
    if (query.trim() !== "") {
        Search(query);
        $(".header_search_dropdown").scroll(function () {
            if (shouldLoadMore) {
                var scrollTop = $(this).scrollTop();
                var windowHeight = $(this).height();
                var docHeight = searchDocument.height();

                if (!searchFetching && scrollTop + windowHeight > docHeight - 100 && !scrolledOnce) {
                    scrolledOnce = true;
                    ViewNextSearchResults();
                } else {
                    scrolledOnce = false;
                }
            }
        });
        function getResultsToLoad(query, offset) {
            searchFetching = true;
            $("#search-loading").show();
            setTimeout(() => {
                $.ajax({
                    url: "Ajax/Search.php",
                    type: "GET",
                    data: {
                        offset: offset,
                        query: query,
                        action: "get-search-results-to-load"
                    },
                    cache: false,
                    success: function (data) {
                        searchFetching = false;
                        if (data.trim()) {
                            $("#searchResults #search-loading").before(data);
                            if (data.trim() == '<div style="text-align: center" hidden>Finished Searching</div>') {
                                shouldLoadMore = false;
                                $(window).off('scroll');
                                $("#search-loading").hide();
                            }
                        } else {
                            shouldLoadMore = false;
                            return;
                        }
                        $("#search-loading").hide();
                    },
                });
            }, 2000);

        }
        function ViewNextSearchResults() {
            // console.log("Calling ViewNextPost");
            if (searchFetching) return;
            getResultsToLoad(query, offset);
            offset += 5;
        }
    }
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
                $("#searchResults #search-loading").before(data);
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
        success: function (data) {
            if (data) {
                sessionStorage.setItem("myData", JSON.stringify(data));
                window.location.href = "search-results.php";
            }
        }
    })
}
function SearchPost(query) {
    $.ajax({
        url: "Ajax/Search.php", // Your server-side search script
        type: "GET",
        dataType: "html",
        data: {
            query: query,
            action: "search-post"
        },
        success: function (postSearchData) {
            if (postSearchData) {
                sessionStorage.setItem("postSearchData", JSON.stringify(postSearchData));
                window.location.href = "search-results.php";
                //console.log(postSearchData)
            }
        }
    })
}
// Show modal post details when click comment
$(".comment-post-btn").click(function(e) {
    e.preventDefault();
    // Reset modal
    $("#post-details-modal .post-details-card").empty();
    var postID = $(this).parent().attr("post-id");
    var userOfPost = $(`.post-card[post-id=${postID}]:eq(0)`).find("a.text-black").text();
    $("#post-details-modal h3").text(userOfPost + "'s post");
    var postCardHTML = $(`.post-card[post-id=${postID}]`)[0].outerHTML;
    $("#post-details-modal .post-details-card").html(postCardHTML);
});