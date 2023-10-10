var shoppingCart = (function () {
    cart = [];
  
    function Item(p_id, p_name, p_price, count) {
      this.p_id = p_id;
      this.p_name = p_name;
      this.p_price = p_price;
      this.count = count;
    }
  
    function saveCart() {
      sessionStorage.setItem("shoppingCart", JSON.stringify(cart));
    }

    var obj = {};
  
    obj.addItemToCart = function (id, name, price, count) {
      for (var item in cart) {
        if (cart[item].p_id === id) {
          cart[item].count++;
          saveCart();
          return;
        }
      }
      var item = new Item(id, name, price, count);
      cart.push(item);
      saveCart();
    };

    obj.removeOneFromCart = function (id) {
      for (var item in cart) {
        if (cart[item].p_id === id) {
          cart[item].count--;
          if (cart[item].count === 0) {
            const indexOfProduct = cart.findIndex(object => {
              return object.p_id === id;
            });
            cart.splice(indexOfProduct, 1);
          }
          saveCart();
          return;
        }
      }

      saveCart();
    };

    obj.removeFromCart = function (id) {
      
      const indexOfProduct = cart.findIndex(object => {
        return object.p_id === id;
      });
      cart.splice(indexOfProduct, 1);

      saveCart();
    };

    return obj;
})();

function eventListener(event) {
  event.preventDefault();
  var p_id = $(this).data("pid");
  var p_name = $(this).data("name");
  var p_price = Number($(this).data("price"));
  shoppingCart.addItemToCart(p_id, p_name, p_price, 1);
  updateTable();
}

function eventDeleteOneListenner(event) {
  event.preventDefault();
  var p_id = $(this).data("pid");
  shoppingCart.removeOneFromCart(p_id);
  updateTable();
}

function eventDeleteListenner(event) {
  event.preventDefault();
  var p_id = $(this).data("pid");
  shoppingCart.removeFromCart(p_id);
  updateTable();
}

function manualPidClick(event) {
  var manual_pid = document.getElementById("manual-pid").value;
  if (document.getElementById("p-"+manual_pid)) {
    var target_button = document.getElementById("p-"+manual_pid);
    target_button.click();
  } else {
    alert("PID "+manual_pid+" not found.");
  }
}

function updateTable() {

    var table = document.getElementsByClassName('order-table');

    if (cart.length === 0) {
      document.getElementById("pay-button").disabled = true;
    } else {
      document.getElementById("pay-button").disabled = false;
    }

    var newBody = document.createElement('tbody')
    newBody.className = "order-table";
    var total_amount = 0;
    for (var i=0; i<cart.length; i++) {
        var newRow = newBody.insertRow(i);
        newRow.insertCell(0).outerHTML = "<th class=\"index\" scope=\"row\">" + (i+1) + "</th>";
        newRow.insertCell(1).innerHTML = cart[i].p_name;
        newRow.insertCell(2).innerHTML = cart[i].count;
        newRow.insertCell(3).innerHTML = cart[i].p_price;
        newRow.insertCell(4).innerHTML = cart[i].p_price*cart[i].count;
        var newCell = newRow.insertCell(5);

        var plus_a = "<a class='add-to-cart-table' data-pid='" + cart[i].p_id + "' data-name='" + cart[i].p_name + "' data-price='" + cart[i].p_price + "' style='color: inherit;' href='#'>";
        var minus_a = "<a class='remove-one-from-cart' data-pid='" + cart[i].p_id + "' style='color: inherit;' href='#'>";
        var clear_a = "<a class='remove-from-cart' data-pid='" + cart[i].p_id + "' style='color: inherit;' href='#'>";

        var button_html = minus_a + '<button type="button" class="btn btn-outline-secondary btn-vsm"><i class="bi bi-dash-lg"></i></button></a>\n' + plus_a + '<button type="button" class="btn btn-outline-secondary btn-vsm"><i class="bi bi-plus-lg"></i></button></a>\n' + clear_a + '<button type="button" class="btn btn-outline-danger btn-vsm"><i class="bi bi-x-lg"></i></button></a>';

        newCell.innerHTML = button_html;
        newCell.className = "button-cell";
        total_amount += cart[i].p_price*cart[i].count;
    }
    table[0].outerHTML = newBody.outerHTML;

    var cart_form = document.getElementById('cart');
    cart_form.value = JSON.stringify(cart);

    document.getElementById('total-amount').innerText = total_amount.toFixed(2);
    var sub_total = (total_amount / 1.07);
    var tax = total_amount - sub_total;
    document.getElementById('sub-total').innerText = sub_total.toFixed(2);
    document.getElementById('tax').innerText = tax.toFixed(2);

    $(".add-to-cart-table").on('click', eventListener);
    $(".remove-one-from-cart").on('click', eventDeleteOneListenner);
    $(".remove-from-cart").on('click', eventDeleteListenner);
}

$(".add-to-cart").on('click', eventListener);

$("#manual-add").on('click', manualPidClick);

$('#manual-pid-modal').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
})


