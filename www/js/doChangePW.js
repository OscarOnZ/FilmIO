function changePWClick(element, newpw){
    alert("called");
    if(element){
        $.ajax({
            type: 'POST',
            url: '/includes/doChangePW.php',
            dataType: 'html',
            data: {pw: newpw},
            success: function(result){
                $(element).addClass("disabled");
                alert(result);
            }
        });
    }
    else{
        alert("problem finding element");
    }

}