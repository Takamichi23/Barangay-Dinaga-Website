  // Show only the imageGallery and organize by year
  const imageGallery = document.getElementById('imageGallery');
  const textGallery = document.getElementById('textGallery');
  const imageBtn = document.getElementById('Gallery');
  const textBtn = document.getElementById('Physical Characteristics');
  
  imageBtn.addEventListener('click', () => {
    // Show the image gallery and hide the text gallery
    imageGallery.classList.remove('hidden');
    textGallery.classList.add('hidden');
  });
  
  textBtn.addEventListener('click', () => { 
    // Show the text gallery and hide the image gallery
    textGallery.classList.remove('hidden');
    imageGallery.classList.add('hidden');
  });
   