<!DOCTYPE html>
<html>
<head>
  <title>Barcode</title>
</head>
<body>
  <div>
    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($exemplar->code, 'I25', 2, 33, array(1,1,1), true) !!}" alt="barcode"/>
  </div>
</body>
</html>