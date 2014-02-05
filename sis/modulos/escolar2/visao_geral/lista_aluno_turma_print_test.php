<!DOCTYPE html>
<html lang="ja">
  <style>
    html   { writing-mode: vertical-rl;
             line-height: 1.6; }
    .main  { page: main;
             columns: 2; column-gap: 1rem; }
    .index { page: index;
             columns: 3; column-gap: 1rem; }
    @page       { margin: auto;    /* center kihon hanmen on page */
                  width:  40rem; } /* 1.6 × 25 lines        */
    @page main  { height: 61rem; } /* 2 × 30 chars + 1 × gap */
    @page index { height: 62rem; } /* 3 × 20 chars + 2 × gap */
	.page{ width:277mm;  padding:1cm;  margin:1cm auto;  height:21cm;  border:1px #D3D3D3 solid; background:white;  box-shadow:0 0 5px rgba(0,0,0,0.1)}
	@media print{
		.page{margin:0; border:initial; border-radius:initial; width:277mm; min-height:initial; box-shadow:initial; background:initial; page-break-after:always;size: landscape}
		@page {size: landscape};
		
	}
  </style>
  <section class="main page"> test  </section>
  <!--<section class="index"> test </section>-->
</html>