pageRedirect( page)
{
	if(page == a)
		header("Location: a.html");
	else if(page == b)
		header("Location: b.html");
	else
		header("Loacation: c.html");
}

var arr = ["../Images/FairOaksNight.jpg", "../Images/linux-background-wallpapers.jpeg", "../Images/linuxPengGreen.jpg", "../Images/UbuntuBlack.jpg"];

(function recurse(counter) {
    var pic = arr[counter];
    $('#rightPane').delay('1200').animate({
        background-image: image
    }, 600);
    delete arr[counter];
    arr.push(color);
    setTimeout(function() {
        recurse(counter + 1);
    }, 200);
})(0);

$(document).ready(function(){
   
   $('#rightPane').delay('9999').animate({
	background-image : '../Images/UbuntuBlack.jpg'
    },600);

)}
