$(document).ready(function(){
    var country,city,masjid,date;
    
    $('#jamat_time_country').on('change', function() {
        country = $(this).val();
        //window.alert(country);
        $.ajax({
            method: 'POST',
            url: 'jamat_time_country.php',
            data: 'country='+country,
            success: function (data) {
                $('#jamat_time_city').html(data);
            }
        }).error(function(){
            alert ('An error occured in s1 select id');
        });
    });
    
    $('#jamat_time_city').on('change', function() {
        country = $('#jamat_time_country').val();
        city = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'jamat_time_city.php',
            data: {country:country, city:city},
            success: function (data) {
                $('#jamat_time_masjid').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });

        /*$.ajax({
            method: 'POST',
            url: 'jamat_time_location.php',
            data: {country:country, city:city},
            success: function (data) {
                $('#jamat_time_masjid').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
        */
    });
    
    $('#jamat_time_masjid').on('change', function() {
        masjid = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'jamat_time_masjid.php',
            data: 'masjid='+masjid,
            success: function (data) {
                $('#jamat_time_date').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });

    $('#jamat_time_date').on('change', function() {
        country = $('#jamat_time_country').val();
        city = $('#jamat_time_city').val();
        masjid = $('#jamat_time_masjid').val();
        date = $(this).val();

        $.ajax({
            method: 'POST',
            url: 'jamat_time_date.php',            
            data: {country:country, city:city, masjid:masjid, date:date},
            success: function (data) {
                $('#jamat_time_div_table1').html(data); 
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });
    

});