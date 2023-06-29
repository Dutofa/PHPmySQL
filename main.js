document.getElementById('color-filter').addEventListener('change', function() {
    var selectedColor = this.value;
    var tweetBoxes = document.getElementsByClassName('tweet-p');
  
    // Parcourir tous les tweet boxes
    for (var i = 0; i < tweetBoxes.length; i++) {
        var tweetBox = tweetBoxes[i];
        var tweetColor = tweetBox.dataset.color;
  
        // Afficher ou masquer le tweet box en fonction de la couleur sélectionnée
        if (selectedColor === '' || tweetColor === selectedColor) {
            tweetBox.style.display = 'block';
        } else {
            tweetBox.style.display = 'none';
        }
    }
});
