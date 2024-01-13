<?php
if (! defined('ABSPATH')) {
    exit;
}

?>
<div class="gm-custom-wrap">
    <div id="map"></div>
    
    <!-- prettier-ignore -->
    <script>(g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({key: "AIzaSyAb8pareaW9BgBJF52KiPbsyoljqKO9_C0", v: "weekly"});</script>
    <div class="gm-help">
        <div class="gm-help1">
            <div class="gm-help1-desc">
                <div class="gm-help1-desc-img">
                    <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage1.png" alt="">
                </div>
                <div class="gm-help1-desc-text">
                    貸主模や管理会社の方自貪が決められた璽に物件情第!を入力し、<br>表示したい写真を指定するだけでこのようにmapで表示されます。<br> さらに、各物件詳細ページ,も自動で作成されます。<br>
                    •入力が•しい方幽けに、入力代行オプション网窟しております。
                </div>
            </div>
            <div class="gm-help1-property">
                <div class="gm-help1-property-header">各物件詳細ページサンプル</div>
                <div class="gm-help1-property-content">
                    <!-- 物件詳細 -->


                    <!-- 物件詳細 -->
                </div>
            </div>
            <div class="gm-help1-flow">
                <div class="gm-help1-flow-tap">
                    流れ
                </div>
                <div class="gm-help-flow-content">
                    1. 商品情報の入力 <br>
                    2. 物件掲戲 <br>
                    3. 契約希望者が 問い合わせ <br>
                    4. 契約お望者の 連絡先通師 <br>
                    5. 自分で契約または伸介を依頼
                </div>
            </div>
            <div class="gm-help1-steps">
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        1. 商品情報の入力
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage2.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        2. 物件掲戲<br><br>
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage5.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        3. 契約希望者が 問い合わせ
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage3.png" alt="">
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        4. 契約お望者の 連絡先通師
                    </div>
                    <div class="gm-help1-steps-img">
                        
                    </div>
                </div>
                <div class="gm-help1-steps1">
                    <div class="gm-help1-steps-text">
                        5. 自分で契約または伸介を依頼
                    </div>
                    <div class="gm-help1-steps-img">
                        <img src="<?php echo get_template_directory_uri() ?>/library/images/toppage4.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="gm-help2">
            
        </div>
        <div class="gm-help3">

        </div>
    </div>
</div>

<script>
    async function initMap() {
    // Request needed libraries.
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const center = { lat: 37.43238031167444, lng: -122.16795397128632 };
    const map = new Map(document.getElementById("map"), {
      zoom: 11,
      center,
      mapId: "4504f8b37365c3d0",
    });
  
    for (const property of properties) {
      const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
        map,
        content: buildContent(property),
        position: property.position,
        title: property.description,
      });
  
      AdvancedMarkerElement.addListener("click", () => {
        toggleHighlight(AdvancedMarkerElement, property);
      });
    }
  }
  
  function toggleHighlight(markerView, property) {
    if (markerView.content.classList.contains("highlight")) {
      markerView.content.classList.remove("highlight");
      markerView.zIndex = null;
    } else {
      markerView.content.classList.add("highlight");
      markerView.zIndex = 1;
    }
  }
  
  function buildContent(property) {
    const content = document.createElement("div");
  
    content.classList.add("property");
    content.innerHTML = `
      <div class="icon">
          <i aria-hidden="true" class="fa fa-icon fa-${property.type}" title="${property.type}"></i>
          <span class="fa-sr-only">${property.type}</span>
      </div>
      <div class="details">
          <div class="price">${property.price}</div>
          <div class="address">${property.address}</div>
          <div class="features">
          <div>
              <i aria-hidden="true" class="fa fa-bed fa-lg bed" title="bedroom"></i>
              <span class="fa-sr-only">bedroom</span>
              <span>${property.bed}</span>
          </div>
          <div>
              <i aria-hidden="true" class="fa fa-bath fa-lg bath" title="bathroom"></i>
              <span class="fa-sr-only">bathroom</span>
              <span>${property.bath}</span>
          </div>
          <div>
              <i aria-hidden="true" class="fa fa-ruler fa-lg size" title="size"></i>
              <span class="fa-sr-only">size</span>
              <span>${property.size} ft<sup>2</sup></span>
          </div>
          </div>
      </div>
      `;
    return content;
  }
  
  const properties = [
    {
      address: "215 Emily St, MountainView, CA",
      description: "Single family house with modern design",
      price: "$ 3,889,000",
      type: "home",
      bed: 5,
      bath: 4.5,
      size: 300,
      position: {
        lat: 37.50024109655184,
        lng: -122.28528451834352,
      },
    },
    {
      address: "108 Squirrel Ln &#128063;, Menlo Park, CA",
      description: "Townhouse with friendly neighbors",
      price: "$ 3,050,000",
      type: "building",
      bed: 4,
      bath: 3,
      size: 200,
      position: {
        lat: 37.44440882321596,
        lng: -122.2160620727,
      },
    },
    {
      address: "100 Chris St, Portola Valley, CA",
      description: "Spacious warehouse great for small business",
      price: "$ 3,125,000",
      type: "warehouse",
      bed: 4,
      bath: 4,
      size: 800,
      position: {
        lat: 37.39561833718522,
        lng: -122.21855116258479,
      },
    },
    {
      address: "98 Aleh Ave, Palo Alto, CA",
      description: "A lovely store on busy road",
      price: "$ 4,225,000",
      type: "store-alt",
      bed: 2,
      bath: 1,
      size: 210,
      position: {
        lat: 37.423928529779644,
        lng: -122.1087629822001,
      },
    },
    {
      address: "2117 Su St, MountainView, CA",
      description: "Single family house near golf club",
      price: "$ 1,700,000",
      type: "home",
      bed: 4,
      bath: 3,
      size: 200,
      position: {
        lat: 37.40578635332598,
        lng: -122.15043378466069,
      },
    },
    {
      address: "197 Alicia Dr, Santa Clara, CA",
      description: "Multifloor large warehouse",
      price: "$ 5,000,000",
      type: "warehouse",
      bed: 5,
      bath: 4,
      size: 700,
      position: {
        lat: 37.36399747905774,
        lng: -122.10465384268522,
      },
    },
    {
      address: "700 Jose Ave, Sunnyvale, CA",
      description: "3 storey townhouse with 2 car garage",
      price: "$ 3,850,000",
      type: "building",
      bed: 4,
      bath: 4,
      size: 600,
      position: {
        lat: 37.38343706184458,
        lng: -122.02340436985183,
      },
    },
    {
      address: "868 Will Ct, Cupertino, CA",
      description: "Single family house in great school zone",
      price: "$ 2,500,000",
      type: "home",
      bed: 3,
      bath: 2,
      size: 100,
      position: {
        lat: 37.34576403052,
        lng: -122.04455090047453,
      },
    },
    {
      address: "655 Haylee St, Santa Clara, CA",
      description: "2 storey store with large storage room",
      price: "$ 2,500,000",
      type: "store-alt",
      bed: 3,
      bath: 2,
      size: 450,
      position: {
        lat: 37.362863347890716,
        lng: -121.97802139023555,
      },
    },
    {
      address: "2019 Natasha Dr, San Jose, CA",
      description: "Single family house",
      price: "$ 2,325,000",
      type: "home",
      bed: 4,
      bath: 3.5,
      size: 500,
      position: {
        lat: 37.41391636421949,
        lng: -121.94592071575907,
      },
    },
  ];
  
  initMap();
</script>