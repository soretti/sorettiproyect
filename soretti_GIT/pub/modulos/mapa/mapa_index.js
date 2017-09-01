 $(document).ready(function(){
	$(".map-box").each(function( index ) {
		coordenadas=$(this).attr('coordenadas').split(",");
		var myLatlng = new google.maps.LatLng(coordenadas[0],coordenadas[1]);
		var myLatlng2 = new google.maps.LatLng(coordenadas[0],coordenadas[1]);
		var mapOptions = {
				  zoom: 15,
				  center:myLatlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				 };

	     map = new google.maps.Map(document.getElementById($(this).attr('id')),mapOptions);
         var marker = new google.maps.Marker({ position: myLatlng2, map: map });
		 var infowindow = new google.maps.InfoWindow({ content: $(this).attr('texto'), position: myLatlng, map:map });
		 infowindow.open(map,marker);
	});

	$(".map-box-frame").each(function( index ) {
		coordenadas=$(this).attr('coordenadas').split(",");
		var myLatlng = new google.maps.LatLng(coordenadas[0],coordenadas[1]);
		var myLatlng2 = new google.maps.LatLng(coordenadas[0],coordenadas[1]);
		var mapOptions = {
				  zoom: 15,
				  center:myLatlng,
				  mapTypeId: google.maps.MapTypeId.ROADMAP
				 };

	     map = new google.maps.Map(document.getElementById($(this).attr('id')),mapOptions);
         var marker = new google.maps.Marker({ position: myLatlng2, map: map });
		 var infowindow = new google.maps.InfoWindow({ content: $(this).attr('texto'), position: myLatlng, map:map });
		 infowindow.open(map,marker);
	});
});
