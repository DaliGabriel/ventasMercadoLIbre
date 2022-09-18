<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-600">

<div style="height: 600px;" class=" bg-white max-w-sm rounded overflow-hidden shadow-xl shadow-cyan-500/50 h-96 grid place-items-center mt-20 mb-4 mx-auto flex space-x-2 justify-center">
    
    <img src="logo.png" />
    
    <h1 class="font-medium leading-tight text-5xl mt-4  text-blue-600 text-center mb-8">
    Mercado Libre
    </h1>
    
    
    <div class=" grid place-items-center justify-center">
        
        <a class="mb-6" href="https://auth.mercadolibre.com.mx/authorization?response_type=code&client_id=client_id&redirect_uri=https://redirect_uri.php">
              <button
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                value="actualizar"
                class="inline-block px-8 py-5 bg-blue-600 text-white font-medium text-lg leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
              >
              Actualizar Stock 
              </button>
          </a>
          
          <a class="mb-2" href="https://auth.mercadolibre.com.mx/authorization?response_type=code&client_id=client_id&redirect_uri=https://redirect_uri.php">
              <button
                type="button"
                data-mdb-ripple="true"
                data-mdb-ripple-color="light"
                value="actualizar"
                class="inline-block px-8 py-5 bg-blue-600 text-white font-medium text-lg leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
              >
              Generar apartados 
              </button>
          </a>

    </div>
</div>
</body>
</html>