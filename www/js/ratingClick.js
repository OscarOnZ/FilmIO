function ratingClick(element, filmID, score){
    if(element){
        $.ajax({
            type: 'GET',
            url: '/includes/createRelation.php',
            dataType: 'html',
            data: {type: 'userFilm', filmID: filmID, score: score},
            success: function(result){
                $(element).addClass("disabled");
                alert(result);
            }
        });
    }
    else{
        alert("problem finding element");
    }

};