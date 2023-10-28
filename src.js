function toggleProducts() {
    var productsSection = document.getElementById('productos');
    var salesSection = document.getElementById('ventas');
    
    if (salesSection.style.display === 'block') {
      salesSection.style.display = 'none';
    }
    
    if (productsSection.style.display === 'block') {
      productsSection.style.display = 'none';
    } else {
      productsSection.style.display = 'block';
    }
  }
  
  function showSales() {
    var productsSection = document.getElementById('productos');
    var salesSection = document.getElementById('ventas');
    
    if (productsSection.style.display === 'block') {
      productsSection.style.display = 'none';
    }
    
    if (salesSection.style.display === 'block') {
      salesSection.style.display = 'none';
    } else {
      salesSection.style.display = 'block';
    }
  }
  