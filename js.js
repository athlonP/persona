function changeImage(imageIndex) {
    var imageContainers = document.getElementsByClassName("image-container");
    for (var i = 0; i < imageContainers.length; i++) {
      imageContainers[i].classList.remove("active");
      if (i === imageIndex - 1) {
        imageContainers[i].classList.add("active");
      }
    }
  }
  