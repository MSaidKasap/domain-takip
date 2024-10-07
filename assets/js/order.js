$(document).ready(function() {
    $('#open-orders').click(function(e) {
      e.preventDefault();

      $.ajax({
        url: 'functions/all_orders.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          var tableRows = '';

          data.forEach(function(order) {
            tableRows += '<tr>';

            tableRows += '<td>' + order.tracking + '</td>';
            tableRows += '<td>' + order.cart_total_items + '</td>';
            tableRows += '<td>' + order.cart_total_price.toFixed(2) + ' ₺</td>';
            tableRows += '<td>' + order.items + '</td>';
            tableRows += '<td><button class="btn btn-warning btn-edit" data-id="' + order.id + '">Düzenle</button></td>';
            tableRows += '</tr>';
          });

          $('#ordersTableBody').html(tableRows);
          $('#ordersModal').modal('show');
        },
        error: function(xhr, status, error) {
          console.error('Bir hata oluştu:', error);
        }
      });
    });

    // Düzenle butonuna tıklanma olayını dinle
    $(document).on('click', '.btn-edit', function() {
      var orderId = $(this).data('id');
      window.location.href = 'edit_order.php?id=' + orderId;
    });
  });



// Masa seçimi kontrol fonksiyonu
function validateTableSelection() {
var tableSelect = document.getElementById('table-select');
var selectedTableId = tableSelect.value;

if (selectedTableId === "") {
  alert('Lütfen bir masa seçin!');
  return false; // Formun gönderilmesini engelle
} else {
  document.getElementById('selected-table-id').value = selectedTableId; // Seçili masayı gizli input'a koy
  return true; // Formun gönderilmesine izin ver
}
}

function printOrderSummary() {
var printWindow = window.open('', '', 'height=600,width=800');
var orderSummaryElement = document.getElementById('order-summary');

// Masa seçimi <select> elementini geçici olarak gizle
var tableSelect = document.getElementById('table-select');
var tableSelectHtml = tableSelect.outerHTML;
tableSelect.style.display = 'none'; // Gizleme işlemi

// İçeriği al
var content = orderSummaryElement.innerHTML;

// Butonları geçici olarak gizle
var noButtonsContent = content.replace(/<button[^>]*>.*?<\/button>/g, '');

printWindow.document.open();
printWindow.document.write('<html><head><title>Sipariş Özeti</title>');
printWindow.document.write('<style>body { font-family: Arial, sans-serif; margin: 20px; } .order-summary { border: 1px solid #ddd; padding: 20px; } .list-group-item { padding: 10px; border-bottom: 1px solid #ddd; } .active { font-weight: bold; }</style>');
printWindow.document.write('</head><body>');

// Yalnızca <select> elementini içermeyen içerik yazdır
printWindow.document.write(noButtonsContent);
printWindow.document.write('</body></html>');
printWindow.document.close();

// Masa seçimi <select> elementini tekrar göster
tableSelect.style.display = '';

printWindow.print();
}


document.addEventListener('DOMContentLoaded', () => {
document.getElementById('table-select').addEventListener('change', (event) => {
  document.getElementById('selected-table-id').value = event.target.value;
});

document.querySelectorAll('.product-card').forEach(card => {
  card.addEventListener('click', () => {
      const itemId = card.getAttribute('data-item-id');

      const formData = new FormData();
      formData.append('item_id', itemId);
      formData.append('quantity', 1); // Miktar her zaman 1

      fetch('order.php', {
          method: 'POST',
          body: formData
      }).then(response => response.text())
          .then(data => {
              location.reload();
          }).catch(error => {
              console.error('Bir hata oluştu:', error);
          });
  });
});
});







  // Tıklanan masa ID'sini saklayacak değişken
  let selectedTableId = null;

  function selectTable(tableId, element) {
    // Seçilen masa ID'sini değişkene ata
    selectedTableId = tableId;

    // Masa kutusunun stilini güncelle
    let items = document.querySelectorAll('.table-item');
    items.forEach(item => {
      item.style.border = '1px solid #ddd'; // Tüm kutuların sınırını varsayılan yap
    });
    element.style.border = '2px solid #000'; // Seçilen masa kutusunun sınırını kalın yap

    // Seçilen masa ID'sini ekrana yazdır
    document.getElementById('selectedTableId').innerText = selectedTableId;

    // Gizli form alanını güncelle
    document.getElementById('selected-table-id').value = selectedTableId;
  }

  function validateTableSelection() {
    if (selectedTableId === null) {
      alert('Lütfen bir masa seçin!');
      return false; // Formun gönderilmesini engelle
    }
    return true; // Formun gönderilmesine izin ver
  }
  