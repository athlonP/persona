<?php
// Include the database connection file
include("conexion.php");

// Establish a database connection
$con = conectar();

// SQL query to retrieve all products
$sql = "SELECT * FROM producto";
$query = mysqli_query($con, $sql);

// Check if the query was successful
if (!$query) {
    die("Error in the query: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tu Página</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/pi.css">
</head>
<body>
<div class="buttons-container">
    <div class="buttons-container">
        <a href="../index.php" class="btn">Inicio</a>
        <a href="ventas.php" class="btn">Ventas</a>
        <a href="" class="btn">Ayuda</a>
        <button id="openAddProductModalBtn" class="btn btn-success">Nuevo registro</button>
    </div>

    

    <div class="container">
        <main>
            <div class="search-container">
                <input type="text" id="searchInput" placeholder="Buscar por descripción">
            </div>
            <section class="product-list">
                <table class="table">
                    <thead class="table-success table-striped">
                        <tr>
                            <th>id</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>Fecha</th>
                            <th>Modificar</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['codigo'] ?></td>
                                <td><?php echo $row['producto'] ?></td>
                                <td><?php echo $row['marca'] ?></td>
                                <td><?php echo $row['precio'] ?></td>
                                <td><?php echo $row['stock'] ?></td>
                                <td><?php echo $row['fecha_compra'] ?></td>
                                <td>
                                    <button class="btn btn-info edit-btn"
                                        data-id="<?php echo $row['id'] ?>"
                                        data-codigo="<?php echo $row['codigo'] ?>"
                                        data-descripcion="<?php echo $row['producto'] ?>"
                                        data-marca="<?php echo $row['marca'] ?>"
                                        data-precio="<?php echo $row['precio'] ?>"
                                        data-stock="<?php echo $row['stock'] ?>"
                                        data-fecha="<?php echo $row['fecha_compra'] ?>">
                                        Editar
                                    </button>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>

    <!-- Modal for adding products -->
    <div class="modal" id="addProductModal">
        <div class="modal-content">
            <span class="close" id="closeAddProductModalBtn">&times;</span>
            <h2 id="addProductModalTitle">Agregar Producto</h2>
            <form id="addProductForm" action="insertar.php" method="POST">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                </div>
                <div class="mb-3">
                    <label for="producto" class="form-label">Descripción:</label>
                    <input type="text" class="form-control" id="producto" name="producto" required>
                </div>
                <div class="mb-3">
                    <label for ="marca" class="form-label">Marca:</label>
                    <input type="text" class="form-control" id="marca" name="marca" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio:</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="stock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="fecha" class="form-label">Fecha de Compra:</label>
                    <input type="date" class="form-control" id="fecha" name="fecha_compra" required>
                </div>
                <button type="submit" class="btn btn-primary" id="saveAddProductBtn">Guardar</button>
            </form>
        </div>
    </div>

    <!-- Modal for editing products -->
    <div class="modal" id="editProductModal">
        <div class="modal-content">
            <span class="close" id="closeEditProductModalBtn">&times;</span>
            <h2 id="editProductModalTitle">Editar Producto</h2>
            <form id="editProductForm" action="update.php" method="POST">
                <input type="hidden" id="editId" name="id" value="">
                <div class="mb-3">
                    <label for="editCodigo" class="form-label">Código:</label>
                    <input type="text" class="form-control" id="editCodigo" name="codigo" required>
                </div>
                <div class="mb-3">
                    <label for="editProducto" class="form-label">Descripción:</label>
                    <input type="text" class="form-control" id="editProducto" name="producto" required>
                </div>
                <div class="mb-3">
                    <label for="editMarca" class="form-label">Marca:</label>
                    <input type="text" class="form-control" id="editMarca" name="marca" required>
                </div>
                <div class="mb-3">
                    <label for="editPrecio" class="form-label">Precio:</label>
                    <input type="number" step="0.01" class="form-control" id="editPrecio" name="precio" required>
                </div>
                <div class="mb-3">
                    <label for="editStock" class="form-label">Stock:</label>
                    <input type="number" class="form-control" id="editStock" name="stock" required>
                </div>
                <div class="mb-3">
                    <label for="editFecha" class="form-label">Fecha de Compra:</label>
                    <input type="date" class="form-control" id="editFecha" name="fecha_compra" required>
                </div>
                <button type="submit" class="btn btn-primary" id="saveEditProductBtn">Actualizar</button>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript to handle modals and other functionality -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
    // Relevant DOM elements
    const openAddProductModalBtn = document.getElementById('openAddProductModalBtn');
    const closeAddProductModalBtn = document.getElementById('closeAddProductModalBtn');
    const closeEditProductModalBtn = document.getElementById('closeEditProductModalBtn');
    const addProductModal = document.getElementById('addProductModal');
    const editProductModal = document.getElementById('editProductModal');
    const addProductForm = document.getElementById('addProductForm');
    const editProductForm = document.getElementById('editProductForm');
    const productTableBody = document.getElementById('productTableBody');
    const searchInput = document.getElementById('searchInput');
    const productRows = document.querySelectorAll('#productTableBody tr');

    searchInput.addEventListener('input', (e) => {
        const searchTerm = e.target.value.toLowerCase();

        productRows.forEach((row) => {
            const descripcion = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            if (descripcion.includes(searchTerm)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Show the modal for adding a new product
    openAddProductModalBtn.addEventListener('click', () => {
        document.getElementById('addProductForm').reset();
        addProductModal.style.display = 'block';
    });

    // Show the modal for editing a product
    productTableBody.addEventListener('click', (e) => {
        if (e.target.classList.contains('edit-btn')) {
            const id = e.target.getAttribute('data-id');
            const codigo = e.target.getAttribute('data-codigo');
            const descripcion = e.target.getAttribute('data-descripcion');
            const marca = e.target.getAttribute('data-marca');
            const precio = e.target.getAttribute('data-precio');
            const stock = e.target.getAttribute('data-stock');
            const fecha = e.target.getAttribute('data-fecha');

            document.getElementById('editId').value = id;
            document.getElementById('editCodigo').value = codigo;
            document.getElementById('editProducto').value = descripcion;
            document.getElementById('editMarca').value = marca;
            document.getElementById('editPrecio').value = precio;
            document.getElementById('editStock').value = stock;
            document.getElementById('editFecha').value = fecha;

            editProductModal.style.display = 'block';
        }
    });

    // Close the modal for adding products
    closeAddProductModalBtn.addEventListener('click', () => {
        addProductModal.style.display = 'none';
    });

    // Close the modal for editing products
    closeEditProductModalBtn.addEventListener('click', () => {
        editProductModal.style.display = 'none';
    });

    // Close the modal if the user clicks outside of it
    window.addEventListener('click', (e) => {
        if (e.target === addProductModal) {
            addProductModal.style.display = 'none';
        }
        if (e.target === editProductModal) {
            editProductModal.style.display = 'none';
        }
    });
</script>
</body>
</html>




