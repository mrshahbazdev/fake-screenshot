<html lang="en">

<head>
	<meta charset="utf-8">
	<link rel="icon" href="/favicon.svg">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="theme-color" content="#000000">
	<meta name="description" content="Web App">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous">
	<base href="<?php echo base_url(); ?>">
	<title>Quick Receipt - Receipt Generator</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
	<link href="assets/css/main.fc9cb7b7.css" rel="stylesheet">
	<link href="assets/css/enhanced.css" rel="stylesheet">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<?php
	$two = $this->uri->segment(2);
	$one = $this->uri->segment(1);
	$username = '';
	if($this->session->userdata('user_id')){
		$quer = $this->db->where('id',$this->session->userdata('user_id'))->get('users');
		if($quer->num_rows() > 0){ $username = $quer->row()->username; }
	}
?>

<body class="qr-app">

	<div id="root">
		<!-- ===== Top bar ===== -->
		<header class="qr-topbar">
			<div class="qr-brand">
				<button class="qr-menu-toggle" onclick="document.body.classList.toggle('sidebar-open')" title="Menu"><i class="fa fa-bars"></i></button>
				<div class="qr-logo"><i class="fa fa-receipt"></i></div>
				<div class="qr-brand-text">
					<h1>Quick Receipt</h1>
					<span>Receipt Generator</span>
				</div>
			</div>
			<div class="qr-topbar-actions">
				<div class="qr-zoom">
					<i class="fa fa-search-minus"></i>
					<input type="range" min="50" max="300" class="slider" name="imageDimension" value="137">
					<i class="fa fa-search-plus"></i>
					<span class="sliderss">137%</span>
				</div>
				<button class="qr-btn qr-btn-primary" onclick="downloadReceipt()" title="Download receipt image"><i class="fa fa-download"></i> Download Image</button>
				<div class="qr-user">
					<i class="fa fa-user-circle"></i>
					<span><?php echo $username ? $username : 'User'; ?></span>
				</div>
				<a href="user/logout"><button class="qr-btn qr-btn-danger" title="Logout"><i class="fa fa-sign-out-alt"></i></button></a>
			</div>
		</header>

		<div class="qr-layout">
			<!-- ===== Sidebar: templates ===== -->
			<aside class="qr-sidebar">
				<div class="qr-sidebar-head">
					<h3><i class="fa fa-layer-group"></i> Templates</h3>
				</div>
				<?php $this->load->view('widgets/sidbar'); ?>
			</aside>

			<!-- ===== Preview ===== -->
			<main class="qr-canvas">
				<div class="qr-canvas-head">
					<h3><i class="fa fa-eye"></i> Preview <span>&mdash; <?php echo $two ? $two : 'Home'; ?></span></h3>
				</div>
				<div class="mobile-view-wrapper">
					<div class="artboard">
						<foreignobject>
							<!-- data -->
							<?php echo $data->data; ?>
						</foreignobject>
					</div>
				</div>
			</main>

			<!-- ===== Controls ===== -->
			<aside class="qr-controls">
				<div class="qr-controls-head">
					<h3><i class="fa fa-sliders-h"></i> Edit Receipt</h3>
					<p>Neeche fields change karein &mdash; receipt live update hogi</p>
				</div>
				<div class="qr-controls-body">
					<!-- Side data -->
					<?php echo $data->sidebar; ?>
					<button class="qr-btn qr-btn-primary qr-btn-block" onclick="downloadReceipt()"><i class="fa fa-download"></i> Download Image</button>
				</div>
			</aside>
		</div>

		<div class="Toastify"></div>
		<?php $this->load->view('widgets/sidebar2'); ?>
	</div>

<?php echo $data->script; ?>

	<script>
		/* ---- toast ---- */
		function qrToast(msg, ok) {
			var t = document.createElement('div');
			t.className = 'qr-toast' + (ok === false ? ' qr-toast-error' : '');
			t.innerHTML = (ok === false ? '<i class="fa fa-exclamation-circle"></i> ' : '<i class="fa fa-check-circle"></i> ') + msg;
			document.body.appendChild(t);
			setTimeout(function(){ t.classList.add('show'); }, 10);
			setTimeout(function(){ t.classList.remove('show'); setTimeout(function(){ t.remove(); }, 300); }, 3000);
		}

		/* ---- font embedding for SVG export ---- */
		async function embedFontsStyle() {
			try {
				const cssResp = await fetch('https://fonts.googleapis.com/css2?family=Mulish:wght@400;600;700;800&display=swap');
				let css = await cssResp.text();
				const urls = [...css.matchAll(/url\((https:[^)]+)\)/g)].map(m => m[1]);
				for (const u of urls) {
					const buf = await (await fetch(u)).arrayBuffer();
					let bin = '';
					new Uint8Array(buf).forEach(b => bin += String.fromCharCode(b));
					css = css.replace(u, 'data:font/woff2;base64,' + btoa(bin));
				}
				return css;
			} catch (e) { return ''; }
		}

		function saveCanvas(canvas) {
			const ts = new Date().toISOString().replace(/[:.]/g, '-').slice(0, 19);
			const filename = 'receipt-' + ts + '.png';
			function triggerDownload(url, filename) {
				const link = document.createElement('a');
				link.href = url; link.download = filename;
				document.body.appendChild(link); link.click();
				setTimeout(function(){ link.remove(); }, 200);
			}
			if (canvas.toBlob) {
				canvas.toBlob(function(blob) {
					const url = URL.createObjectURL(blob);
					triggerDownload(url, filename);
					setTimeout(function(){ URL.revokeObjectURL(url); }, 120000);
					qrToast('Receipt image downloaded');
				}, 'image/png');
			} else {
				triggerDownload(canvas.toDataURL('image/png'), filename);
				qrToast('Receipt image downloaded');
			}
		}

		/* ---- universal download: works for SVG and HTML receipts ---- */
		async function downloadReceipt() {
			const svgElement = document.getElementById('mySvg');
			if (svgElement) {
				try {
					const clone = svgElement.cloneNode(true);
					const fontCss = await embedFontsStyle();
					if (fontCss) {
						const styleEl = document.createElementNS('http://www.w3.org/2000/svg', 'style');
						styleEl.textContent = fontCss;
						clone.insertBefore(styleEl, clone.firstChild);
					}
					const svgString = new XMLSerializer().serializeToString(clone);
					const svgDataUrl = 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent(svgString);
					const svgSize = svgElement.getBoundingClientRect();
					const scale = 2;
					const canvas = document.createElement('canvas');
					canvas.width = svgSize.width * scale;
					canvas.height = svgSize.height * scale;
					const ctx = canvas.getContext('2d');
					ctx.scale(scale, scale);
					await new Promise(function(resolve, reject) {
						const img = new Image();
						img.onload = function() {
							ctx.fillStyle = '#ffffff';
							ctx.fillRect(0, 0, svgSize.width, svgSize.height);
							ctx.drawImage(img, 0, 0, svgSize.width, svgSize.height);
							resolve();
						};
						img.onerror = reject;
						img.src = svgDataUrl;
					});
					saveCanvas(canvas);
					return;
				} catch (e) {
					console.error('SVG export failed, falling back to html2canvas', e);
				}
			}
			/* HTML receipts (most templates) */
			const target = document.querySelector('.artboard');
			if (!target) { qrToast('Kuch download karne ke liye nahi mila', false); return; }
			try {
				const canvas = await html2canvas(target, { scale: 2, useCORS: true, backgroundColor: '#ffffff' });
				saveCanvas(canvas);
			} catch (e) {
				console.error(e);
				qrToast('Download fail ho gaya - dobara try karein', false);
			}
		}

		/* ---- zoom slider ---- */
		document.addEventListener('DOMContentLoaded', function() {
			var slider = document.querySelector('.slider');
			var sliderSpan = document.querySelector('.sliderss');
			var element = document.getElementById('mySvg') || document.querySelector('.artboard');
			if (!slider || !element) return;

			function applyZoom() {
				if (element.tagName && element.tagName.toLowerCase() === 'svg') {
					element.setAttribute('width', slider.value + '%');
				} else {
					element.style.transformOrigin = 'top center';
					element.style.transform = 'scale(' + (slider.value / 137) + ')';
				}
				if (sliderSpan) sliderSpan.textContent = slider.value + '%';
			}
			applyZoom();
			slider.addEventListener('input', applyZoom);
		});

		/* ---- highlight current template + overlay menu ---- */
		document.addEventListener('DOMContentLoaded', function() {
			var targetElement = document.querySelector('a[href="<?php echo $one; ?>/<?php echo $two; ?>"]');
			if (targetElement) {
				targetElement.classList.add('active-page');
				targetElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
			}
			var overlay = document.querySelector('.list-all-items');
			var openBtn = document.querySelector('.list-all-btn button');
			var closeBtn = document.querySelector('.list-close button');
			if (overlay && openBtn) openBtn.addEventListener('click', function() { overlay.style.top = '0'; });
			if (overlay && closeBtn) closeBtn.addEventListener('click', function() { overlay.style.top = '100%'; });
		});
	</script>
</body>

</html>
