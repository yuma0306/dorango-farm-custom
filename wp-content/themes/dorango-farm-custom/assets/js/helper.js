const addImageAttr=()=>{for(const t of document.getElementsByTagName("img"))!function(n){return new Promise(function(e){const t=new Image;t.src=n,t.onload=function(){e(t)}})}(t.getAttribute("src")).then(function(e){t.hasAttribute("width")||t.setAttribute("width",e.width),t.hasAttribute("height")||t.setAttribute("height",e.height)})},redirectToPage=()=>{Array.from(document.getElementsByClassName("js-select-redirect")).forEach(t=>{t.addEventListener("change",function(){var e=t.value;e&&(window.location.href=e)})})},resizeWindow=()=>{let e=window.innerWidth;window.addEventListener("resize",()=>{e!==window.innerWidth&&(e=window.innerWidth)})},createToc=()=>{const i="anchor-";var e,t,n=document.querySelector("#js-toc"),r=document.querySelectorAll("#js-article h1, #js-article h2, #js-article h3, #js-article h4, #js-article h5, #js-article h6");const c=[];let a=1;let o=-1;try{const d=e=>{var t=document.createElement("li"),n=document.createElement("a");return e.id=e.id||""+i+a++,n.href="#"+e.id,n.innerText=e.innerText,n.className="toc__link",t.appendChild(n),t},l=(e,t,n)=>{do{if(e[t+=n])return e[t]}while(0<t&&t<7);return!1};r.forEach(e=>{var t=Number(e.tagName.substring(1)),n=l(c,t,-1),n=(o>t&&(c.length=t+1),c[t]||(c[t]=document.createElement("ol"),c[t].className="toc__list",n.lastChild&&n.lastChild.appendChild(c[t])),d(e));n.className="toc__item",c[t].appendChild(n),o=t}),c.length&&(e=n,t=l(c,0,1),e.appendChild(t.cloneNode(!0)))}catch(e){}};