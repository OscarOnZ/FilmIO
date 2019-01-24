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
function acceptFriendReqClick(element, username){
    alert("called");
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'acceptFR', username: username},
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

function denyFriendReqClick(element, username){
    alert("called");
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'denyFR', username: username},
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
function withdrawFriendReqClick(element, username){
    alert("called");
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'withdrawFR', username: username},
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
