document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', filterTable);
  });
  
  function filterTable() {
    var searchValue = this.value.toLowerCase();
    var tableRows = document.querySelectorAll('.product-list table tr');
  
    for (var i = 1; i < tableRows.length; i++) {
      var row = tableRows[i];
      var rowData = row.innerHTML.toLowerCase();
      
      if (rowData.includes(searchValue)) {
        row.style.display = 'table-row';
      } else {
        row.style.display = 'none';
      }
    }
  }
  