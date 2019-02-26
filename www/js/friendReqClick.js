/*
 * Copyright (c) Oscar Cameron 2019.
 */

function friendReqClick(element, username){
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'userUser', username: username},
            success: function(result){
                $(element).addClass("disabled");
            }
        });
    }
    else{
        alert("problem finding element");
    }

}



