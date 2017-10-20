<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
function get_country(){
    var url='https://www.greenpeace.or.th/noom/world_province_2/index_c.php' ;
	$.ajax({
  		url:  url,
  		dataType: 'jsonp',
  		success: function (data) {
  			$("select[name='supporter.country']" ).empty();
  			$("select[name='supporter.country']" ).append(data['list']);
  			$("select[name='supporter.region']" ).empty();
  			$("select[name='supporter.region']" ).append(data['province']);
  			var select_country=$("select[name='supporter.country']").val();
  			}  
		});
	}
	
function getprovince(c_id){
	var url='https://www.greenpeace.or.th/noom/world_province/index.php?m=province&country_code='+c_id ;
	$.ajax({
  		url:  url,
  		dataType: 'jsonp',
  		success: function (data) {
  			$("select[name='supporter.region']" ).empty();
  			$("select[name='supporter.region']" ).append( $('<option></option>').val('').html('Please select') );   
			for (var key in data) {
  				if (data.hasOwnProperty(key)) {
  					$("select[name='supporter.region']" ).append( $('<option></option>').val(key).html(data[key]) );        
  					}
				}
  			}  
		});
	}
</script>

<script>
$( document ).ready(function() {
	get_country();
	$("select[name='supporter.country']").on('change', function() {
		var select_country=$("select[name='supporter.country']").val();
		getprovince(select_country);
		});
	});
</script>