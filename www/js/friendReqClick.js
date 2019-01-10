/*
 * Copyright (c) Oscar Cameron 2019.
 */

function friendReqClick(element, username){
    alert("called");
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'userUser', username: username},
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