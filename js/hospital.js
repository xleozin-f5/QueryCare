function initMap() {
  var hospitalLocation = { lat: 41.563921, lng: -8.419662 };
  var map = new google.maps.Map(document.getElementById('map'), {
    center: hospitalLocation,
    zoom: 15
  });

  var marker = new google.maps.Marker({
    position: hospitalLocation,
    map: map,
    title: 'Hospital Local'
  });
}
