<!DOCTYPE html>
<html lang="en">
  <meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Clip The Pic</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport"/>
    <link rel="icon" href="assets/img/obeth.webp" type="image/x-icon"/>
<!-- Font Awesome CDN -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

<style>
 .revision-tool {
      border: 1px solid #000;
      padding: 20px;
      position: relative;
    }

    .upload-section {
      text-align: right;
    }

    .upload-btn {
      background-color: #f1f1f1;
      padding: 8px 15px;
      border: 1px solid #000;
      cursor: pointer;
    }

    .main-content {
      display: flex;
      margin-top: 20px;
      gap: 20px;
    }

    .image-section {
      flex: 1;
      position: relative;
      border: 1px solid #000;
      min-height: 400px;
      background: #eee;
    }

    .uploaded-image {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    .feedback-section {
      flex: 1;
      border: 1px solid #000;
      padding: 20px;
      position: relative;
    }

    .feedback-section h4 {
      margin-top: 0;
    }

    .feedback-list {
      margin-top: 10px;
      padding-left: 20px;
    }

    .submit-btn {
      position: absolute;
      bottom: 20px;
      right: 20px;
      background: #ccc;
      border: 1px solid #000;
      padding: 10px 20px;
      cursor: pointer;
    }

    .bottom-tools {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
      font-size: 14px;
      padding: 10px 0;
    }

    .box {
      position: absolute;
      border: 2px dashed;
      pointer-events: none;
      font-weight: bold;
      font-size: 14px;
      color: black;
    }

#backgroundCanvas, #drawingCanvas {
   width:-webkit-fill-available;
    height: 397px;
}


.color-circle {
  display: inline-block;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  border: 2px solid #000;
  cursor: pointer;
  margin-left: 10px;
}
.color-circle:hover {
  transform: scale(1.2);
}


</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/custom.js'])
</head>
<body class="bg-gray-100">

<div class="wrapper">

   <x-sidebar />

<div class="main-panel">
  <x-navbar />

  {{$slot}}
</div>
  <x-footer />

  @include('sweetalert::alert')
</body>
</html>
