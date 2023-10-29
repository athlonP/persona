<?php
include("conexion.php");
$con = conectar();

// Obtener datos de productos
$sql = "SELECT * FROM producto ORDER BY producto"; // Ordenar por nombre de producto
$query = mysqli_query($con, $sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Precios y Listado de Productos</title>
    <link rel="stylesheet" href="vent.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Actualizar Precios y Listado de Productos</h1>
        <h2>Aumentar Precio</h2>
        <div class="input-group mb-3">
            <input type="number" id="aumentoPorcentaje" class="form-control" placeholder="Porcentaje de aumento">
            <div class="input-group-append">
                <button class="btn btn-primary" onclick="actualizarPrecios()">Aplicar Aumento</button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_array($query)) { ?>
                    <tr>
                        <td><?php echo $row['id'] ?></td>
                        <td><?php echo $row['codigo'] ?></td>
                        <td><?php echo $row['producto'] ?></td>
                        <td><?php echo $row['marca'] ?></td>
                        <td id="precio-<?php echo $row['id'] ?>"><?php echo $row['precio'] ?></td>
                        <td id="stock-<?php echo $row['id'] ?>"><?php echo $row['stock'] ?></td>
                        <td>
                            <button class="btn btn-success seleccionar-producto" data-producto="<?php echo $row['producto'] ?>" data-marca="<?php echo $row['marca'] ?>" data-stock="<?php echo $row['stock'] ?>" data-id="<?php echo $row['id'] ?>" onclick="abrirSeleccionarProductoModal(this)">Seleccionar</button>
                            <button class="agregar-stock" data-producto="<?php echo $row['producto'] ?>" data-id="<?php echo $row['id'] ?>" onclick="abrirAgregarStockModal(this)">
    <span class="icon-text"><i class="fas fa-plus"></i> <span class="agregar-stock-text"></span></span></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-warning mostrar-bajo-stock" id="mostrarBajoStock" onclick="mostrarProductosBajoStock()">
            Mostrar Bajo Stock
        </button>
    </div>

    <div id="bajoStockModal" class="modal">
        <div class="modal-content">
            <h2>Productos con Bajo Stock</h2>
            <ul id="productosBajoStock"></ul>
            <button class="btn btn-secondary" id="cerrarModal" onclick="cerrarModal()">Cerrar</button>
        </div>
    </div>

    <!-- Modal para seleccionar producto -->
    <div id="seleccionarProductoModal" class="modal">
        <div class="modal-content">
            <h2>Seleccionar Producto</h2>
            <p>Nombre del Producto: <span id="modalNombre"></span></p>
            <p>Marca: <span id="modalMarca"></span></p>
            <p>Cantidad Disponible: <span id="modalStock"></span></p>
            <form id="seleccionarProductoForm">
                <input type="hidden" id="ventaProductoId" value="">
                <div class="form-group">
                    <label for="ventaCantidad">Cantidad:</label>
                    <input type="number" id="ventaCantidad" class="form-control" placeholder="Cantidad" required>
                </div>
                <button type="submit" class="btn btn-primary">Enviar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarSeleccionarProductoModal()">Cancelar</button>
            </form>
        </div>
    </div>

    <!-- Modal para agregar stock -->
    <div id="agregarStockModal" class="modal">
        <div class="modal-content">
            <h2>Agregar Stock</h2>
            <p>Producto: <span id="modalNombreStock"></span></p>
            <form id="agregarStockForm">
                <input type="hidden" id="productoIdStock" value="">
                <div class="form-group">
                    <label for="cantidadStock">Cantidad a Agregar:</label>
                    <input type="number" id="cantidadStock" class="form-control" placeholder="Cantidad a Agregar" required>
                </div>
                <button type="submit" class="btn btn-primary">Agregar</button>
                <button type="button" class="btn btn-secondary" onclick="cerrarAgregarStockModal()">Cancelar</button>
            </form>
        </div>
    </div>
<script>
    function abrirSeleccionarProductoModal(button) {
        const productoId = button.getAttribute("data-id");
        const productoNombre = button.getAttribute("data-producto");
        const productoMarca = button.getAttribute("data-marca");
        const productoStock = button.getAttribute("data-stock");

        const ventaProductoId = document.getElementById("ventaProductoId");
        ventaProductoId.value = productoId;
        
        const modalNombre = document.getElementById("modalNombre");
        const modalMarca = document.getElementById("modalMarca");
        const modalStock = document.getElementById("modalStock");
        
        modalNombre.textContent = productoNombre;
        modalMarca.textContent = productoMarca;
        modalStock.textContent = productoStock;

        const seleccionarProductoModal = document.getElementById("seleccionarProductoModal");
        seleccionarProductoModal.style.display = "block";
    }

    function cerrarSeleccionarProductoModal() {
        const seleccionarProductoModal = document.getElementById("seleccionarProductoModal");
        seleccionarProductoModal.style.display = "none";
    }

    document.getElementById("seleccionarProductoForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const productoId = document.getElementById("ventaProductoId").value;
        const cantidad = document.getElementById("ventaCantidad").value;

        fetch("procesar_venta.php", {
            method: "POST",
            body: JSON.stringify({ productoId, cantidad }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                cerrarSeleccionarProductoModal();
            }
        });
    });

    function abrirAgregarStockModal(button) {
        const productoId = button.getAttribute("data-id");
        const productoNombre = button.getAttribute("data-producto");

        const productoIdStock = document.getElementById("productoIdStock");
        productoIdStock.value = productoId;
        
        const modalNombreStock = document.getElementById("modalNombreStock");
        
        modalNombreStock.textContent = productoNombre;

        const agregarStockModal = document.getElementById("agregarStockModal");
        agregarStockModal.style.display = "block";
    }

    function cerrarAgregarStockModal() {
        const agregarStockModal = document.getElementById("agregarStockModal");
        agregarStockModal.style.display = "none";
    }

    document.getElementById("agregarStockForm").addEventListener("submit", function(event) {
        event.preventDefault();
        const productoId = document.getElementById("productoIdStock").value;
        const cantidad = document.getElementById("cantidadStock").value;

        // Realizar una solicitud AJAX o ejecutar código PHP para agregar stock al producto en la base de datos.
        
        // Luego, puedes actualizar la vista (la cantidad de stock en la tabla) aquí.

        cerrarAgregarStockModal();
    });

    function actualizarPrecioEnDB(id, nuevoPrecio) {
        const data = { id, nuevoPrecio };
        
        fetch("actualizar_precio_db.php", {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Precio actualizado en la base de datos");
            } else {
                console.error("Error al actualizar el precio en la base de datos");
            }
        })
        .catch(error => {
            console.error("Error en la solicitud AJAX: " + error);
        });
    }

    function actualizarPrecios() {
        const aumentoPorcentaje = document.getElementById("aumentoPorcentaje").value;
        if (isNaN(aumentoPorcentaje) || aumentoPorcentaje <= 0) {
            alert("Porcentaje de aumento no válido");
            return;
        }

        const precioElements = document.querySelectorAll("[id^='precio-']");
        precioElements.forEach(function(precioElement) {
            const id = precioElement.id.replace("precio-", "");
            const precioActual = parseFloat(precioElement.textContent);
            const nuevoPrecio = precioActual * (1 + (aumentoPorcentaje / 100));
            precioElement.textContent = nuevoPrecio.toFixed(2);
            actualizarPrecioEnDB(id, nuevoPrecio);
        });
    }

    function mostrarProductosBajoStock() {
    const rows = document.querySelectorAll("table tbody tr");
    const productosBajoStock = document.getElementById("productosBajoStock");
    productosBajoStock.innerHTML = "";

    rows.forEach(function(row) {
        const stockElement = row.querySelector("td[id^='stock-']");
        if (stockElement) {
            const stock = parseInt(stockElement.textContent);
            if (stock < 5) {
                const productoNombre = row.querySelector("td:nth-child(3)").textContent;
                const li = document.createElement("li");
                li.textContent = productoNombre;
                li.addEventListener("click", function() {
                    const productoIdElement = document.getElementById("ventaProductoId"); // Corregido a "ventaProductoId"
                    if (productoIdElement) {
                        const productoId = row.querySelector("td[id^='stock-']").id.replace("stock-", "");
                        productoIdElement.value = productoId;
                    } else {
                        console.error("Elemento 'ventaProductoId' no encontrado.");
                    }
                    abrirStockModal();
                });
                productosBajoStock.appendChild(li);
            }
        }
    });

    const bajoStockModal = document.getElementById("bajoStockModal");
    bajoStockModal.style.display = "block";
}



    function abrirStockModal() {
        const modificarStockModal = document.getElementById("modificarStockModal");
        modificarStockModal.style.display = "block";
    }

    function cerrarStockModal() {
        const modificarStockModal = document.getElementById("modificarStockModal");
        modificarStockModal.style.display = "none";
    }

    function cerrarModal() {
        const bajoStockModal = document.getElementById("bajoStockModal");
        bajoStockModal.style.display = "none";
    }
    function toggleAgregarStockText(button) {
    button.classList.toggle("clicked");
}

</script>
</body>
</html>