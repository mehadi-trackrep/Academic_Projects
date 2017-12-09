$(document).ready(function(){
    var country,city;
    
    $('#insert_jamat_time_country').on('change', function() {
        country = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'jamat_time_country.php',
            data: 'country='+country,
            success: function (data) {
                $('#insert_jamat_time_city').html(data);
            }
        }).error(function(){
            alert ('An error occured in s1 select id');
        });
    });
    
    $('#insert_jamat_time_city').on('change', function() {
        country = $('#insert_jamat_time_country').val();
        city = $(this).val();
        $.ajax({
            method: 'POST',
            url: 'jamat_time_city.php',
            data: {country:country, city:city},
            success: function (data) {
                $('#insert_jamat_time_masjid').html(data);
            }
        }).error(function(){
            alert ('An error occured  in s2 select id');
        });
    });  

});