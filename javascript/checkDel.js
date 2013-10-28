// JavaScript Document
// checkDel* function is used to check if an user wants to delete some data
// * will distinct what is the thing that the user wants to delete
<!--
function checkDelArticle(blogid, articleid) {
	var str = "Are you sure you want to delete this article?";
	var ans = confirm(str);
	var link = new Array();
	link[1] = "delete_article.php?blogid="+blogid+"&id="+articleid;
	new_url = link[1];
	if(ans) {
        window.location = new_url;
    } else {
    }
}

function checkDelComment(blogid, commentid) {
	var str = "Are you sure you want to delete this comment?";
	var ans = confirm(str);
	var link = new Array();
	link[1] = "delete_comment.php?blogid="+blogid+"&id="+id;
	new_url = link[1];
	if(ans) {
        window.location = new_url;
    } else {
    }
}
-->
