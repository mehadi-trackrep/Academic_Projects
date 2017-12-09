$(document).ready(function(){
    var q,country,city,month,day;
    
    $('#index_country').on('change', function() {
        country = $(this).val();
        //window.alert(country);
        $.ajax({
            method: 'POST',
            url: 'index_country.php',
            data: 'country='+country,
            success: function (data) {
                $('#index_city').html(data);
            }
        }).error(function(){
            alert ('An error occured in s1 select id');
        });
    });
    
    $('#index_city').on('change', function() {
        city = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'index_city.php',
            data: 'city='+city,
            success: function (data) {
                $('#index_month').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });
    
    $('#index_month').on('change', function() {
        month = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'index_month.php',
            data: 'month='+month,
            success: function (data) {
                $('#index_day').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });

    $('#index_day').on('change', function() {
        country = $('#index_country').val();
        city = $('#index_city').val();
        month = $('#index_month').val();
        day = $(this).val();

        $.ajax({
            method: 'POST',
            url: 'index_day.php',            
            data: {country:country, city:city, month:month, day:day},
            success: function (data) {
                $('#index_div_table1').html(data); 
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });
    

});