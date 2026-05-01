<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" href="/favicon.svg">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="theme-color" content="#000000">
	<meta name="description" content="Web App">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
	<base href="<?php echo base_url(); ?>">
	<title>Withdrawal Billing - Easy way to generate withdrawal billing</title>
	<script src="assets/js/main.20648ec0.js"></script>
	<link href="assets/css/main.fc9cb7b7.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
  <?php 
    $two = $this->uri->segment(2);
    $one = $this->uri->segment(1);
   ?>

<script>
      document.addEventListener('DOMContentLoaded', function() {
     
        var targetElement = document.querySelector('a[href="<?php echo $one; ?>/<?php echo $two; ?>"]');
        setInterval(function() {
          targetElement.scrollIntoView({ behavior: 'smooth' });
        },5000);
      // Check if the element exists
      if (targetElement) {
        // Scroll to the element
        targetElement.scrollIntoView({ behavior: 'smooth' });
      }
       });
  </script>
<body>

	<div id="root">
		<section class="billing_wrapper">
			<div class="billing_parents">
				<div class="billing_childs">
					<div class="billing-logo-wrapper">
						<div class="billing-logo"><i class="fa fa-user"></i></div>
					</div>
          <?php 
            if($this->session->userdata('user_id')){
              $quer = $this->db->where('id',$this->session->userdata('user_id'))->get('users');
              if($quer->num_rows() > 0){
                echo "<h4>Welcome, ".$quer->row()->username."</h4>";
                
              }
            }
          ?>
					
					<h3>Quick Receipt <span>(V.4)</span></h3>
					<a href="user/logout"><button class="logout-btn">Logout</button></a>
					<?php $this->load->view('widgets/sidbar'); ?>
				</div>
				<div class="billing_childs">
					<div class="Toastify"></div>
					<div class="app-heading">
						<h3>PREVIEW - <span>Mobile 1</span></h3>
						<div class="slidecontainer">
							<button>Screenshot <i class="fa fa-copy"></i></button><span class="sliderss">137%</span>
							<input type="range" min="1" max="3700" class="slider" name="imageDimension" value="137">
						</div>
					</div>
					<div class="mobile-view-wrapper">
						<div class="artboard">
							<foreignobject>
								<!-- data -->
								<?php echo $data->data; ?>
							</foreignobject>
						</div>
					</div>
				</div>
<style type="text/css">
  .mobile-view-wrapper {
    width: 100%;
    max-height: 100vh; /* Full viewport height on mobile */
    overflow-y: auto; /* Enables vertical scrolling */
    overflow-x: auto; /* Prevents horizontal scrolling */
    background-color: #f0f0f0;
    padding: 10px;
    box-sizing: border-box;
}
</style>
<?php echo $data->script; ?>

	<button onclick="captureSvg()">Capture SVG</button>

  <script>
    function captureSvg() {
      const svgElement = document.getElementById('mySvg');
      const serializer = new XMLSerializer();
      const svgString = serializer.serializeToString(svgElement);
      const svgDataUrl = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
      const img = new Image();
      const canvas = document.createElement('canvas');
      const svgSize = svgElement.getBoundingClientRect();
      canvas.width = svgSize.width;
      canvas.height = svgSize.height;
      const ctx = canvas.getContext('2d');

      img.onload = () => {
        // Optionally set canvas background color
        // ctx.fillStyle = 'red'; // Example background color
        // ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
        const link = document.createElement('a');
        link.download = 'captured-image.jpg';
        link.href = canvas.toDataURL('image/jpg');
        link.click();
      };

      img.onerror = (e) => console.error('Image load error:', e);

      img.src = svgDataUrl;
    }

    document.addEventListener('DOMContentLoaded', function() {
    // Get the slider and value display elements
    var slider = document.querySelector('.slider');
    var sliderSpan = document.querySelectorAll('.slidecontainer .sliderss');
    

    var element = document.getElementById('mySvg');


    element.setAttribute('width', slider.value+'%');
    sliderSpan.textContent = slider.value+'%';
    // Set initial display value
    

    // Update value display when slider changes
    slider.addEventListener('input', function() {
        element.setAttribute('width', slider.value+'%');
        sliderSpan.textContent = slider.value+'%';
    });
});


  </script>
  
    
				<div class="billing_childs">
					<div class="app-heading">
						<h3>CONTROLS</h3></div>
					<!-- Side data -->
					<?php echo $data->sidebar; ?>
				</div>
			</div>
		</section>
		<?php $this->load->view('widgets/sidebar2'); ?>
	</div>
</body>

</html>