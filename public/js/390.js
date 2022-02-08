"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[390],{3857:(e,n,t)=>{function r(e,n){let t=e.length-n,r=0;do{for(let t=n;t>0;t--)e[r+n]+=e[r],r++;t-=n}while(t>0)}function s(e,n,t){let r=0,s=e.length;const o=s/t;for(;s>n;){for(let t=n;t>0;--t)e[r+n]+=e[r],++r;s-=n}const a=e.slice();for(let n=0;n<o;++n)for(let r=0;r<t;++r)e[t*n+r]=a[(t-r-1)*o+n]}t.d(n,{Z:()=>o});class o{async decode(e,n){const t=await this.decodeBlock(n),o=e.Predictor||1;if(1!==o){const n=!e.StripOffsets;return function(e,n,t,o,a,i){if(!n||1===n)return e;for(let e=0;e<a.length;++e){if(a[e]%8!=0)throw new Error("When decoding with predictor, only multiple of 8 bits are supported.");if(a[e]!==a[0])throw new Error("When decoding with predictor, all samples must have the same size.")}const c=a[0]/8,l=2===i?1:a.length;for(let i=0;i<o&&!(i*l*t*c>=e.byteLength);++i){let o;if(2===n){switch(a[0]){case 8:o=new Uint8Array(e,i*l*t*c,l*t*c);break;case 16:o=new Uint16Array(e,i*l*t*c,l*t*c/2);break;case 32:o=new Uint32Array(e,i*l*t*c,l*t*c/4);break;default:throw new Error(`Predictor 2 not allowed with ${a[0]} bits per sample.`)}r(o,l)}else 3===n&&(o=new Uint8Array(e,i*l*t*c,l*t*c),s(o,l,c))}return e}(t,o,n?e.TileWidth:e.ImageWidth,n?e.TileLength:e.RowsPerStrip||e.ImageLength,e.BitsPerSample,e.PlanarConfiguration)}return t}}},4390:(e,n,t)=>{t.r(n),t.d(n,{default:()=>w});var r=t(3857);const s=new Int32Array([0,1,8,16,9,2,3,10,17,24,32,25,18,11,4,5,12,19,26,33,40,48,41,34,27,20,13,6,7,14,21,28,35,42,49,56,57,50,43,36,29,22,15,23,30,37,44,51,58,59,52,45,38,31,39,46,53,60,61,54,47,55,62,63]),o=4017,a=799,i=3406,c=2276,l=1567,f=3784,h=5793,u=2896;function d(e,n){let t=0;const r=[];let s=16;for(;s>0&&!e[s-1];)--s;r.push({children:[],index:0});let o,a=r[0];for(let i=0;i<s;i++){for(let s=0;s<e[i];s++){for(a=r.pop(),a.children[a.index]=n[t];a.index>0;)a=r.pop();for(a.index++,r.push(a);r.length<=i;)r.push(o={children:[],index:0}),a.children[a.index]=o.children,a=o;t++}i+1<s&&(r.push(o={children:[],index:0}),a.children[a.index]=o.children,a=o)}return r[0].children}function m(e,n,t,r,o,a,i,c,l){const{mcusPerLine:f,progressive:h}=t,u=n;let d=n,m=0,b=0;function p(){if(b>0)return b--,m>>b&1;if(m=e[d++],255===m){const n=e[d++];if(n)throw new Error(`unexpected marker: ${(m<<8|n).toString(16)}`)}return b=7,m>>>7}function w(e){let n,t=e;for(;null!==(n=p());){if(t=t[n],"number"==typeof t)return t;if("object"!=typeof t)throw new Error("invalid huffman sequence")}return null}function k(e){let n=e,t=0;for(;n>0;){const e=p();if(null===e)return;t=t<<1|e,--n}return t}function g(e){const n=k(e);return n>=1<<e-1?n:n+(-1<<e)+1}let y=0;let P,C=0;function T(e,n,t,r,s){const o=t%f,a=(t/f|0)*e.v+r,i=o*e.h+s;n(e,e.blocks[a][i])}function A(e,n,t){const r=t/e.blocksPerLine|0,s=t%e.blocksPerLine;n(e,e.blocks[r][s])}const v=r.length;let x,L,E,I,U,D;D=h?0===a?0===c?function(e,n){const t=w(e.huffmanTableDC),r=0===t?0:g(t)<<l;e.pred+=r,n[0]=e.pred}:function(e,n){n[0]|=p()<<l}:0===c?function(e,n){if(y>0)return void y--;let t=a;const r=i;for(;t<=r;){const r=w(e.huffmanTableAC),o=15&r,a=r>>4;if(0===o){if(a<15){y=k(a)+(1<<a)-1;break}t+=16}else t+=a,n[s[t]]=g(o)*(1<<l),t++}}:function(e,n){let t=a;const r=i;let o=0;for(;t<=r;){const r=s[t],a=n[r]<0?-1:1;switch(C){case 0:{const n=w(e.huffmanTableAC),t=15&n;if(o=n>>4,0===t)o<15?(y=k(o)+(1<<o),C=4):(o=16,C=1);else{if(1!==t)throw new Error("invalid ACn encoding");P=g(t),C=o?2:3}continue}case 1:case 2:n[r]?n[r]+=(p()<<l)*a:(o--,0===o&&(C=2===C?3:0));break;case 3:n[r]?n[r]+=(p()<<l)*a:(n[r]=P<<l,C=0);break;case 4:n[r]&&(n[r]+=(p()<<l)*a)}t++}4===C&&(y--,0===y&&(C=0))}:function(e,n){const t=w(e.huffmanTableDC),r=0===t?0:g(t);e.pred+=r,n[0]=e.pred;let o=1;for(;o<64;){const t=w(e.huffmanTableAC),r=15&t,a=t>>4;if(0===r){if(a<15)break;o+=16}else o+=a,n[s[o]]=g(r),o++}};let q,z,O=0;z=1===v?r[0].blocksPerLine*r[0].blocksPerColumn:f*t.mcusPerColumn;const M=o||z;for(;O<z;){for(L=0;L<v;L++)r[L].pred=0;if(y=0,1===v)for(x=r[0],U=0;U<M;U++)A(x,D,O),O++;else for(U=0;U<M;U++){for(L=0;L<v;L++){x=r[L];const{h:e,v:n}=x;for(E=0;E<n;E++)for(I=0;I<e;I++)T(x,D,O,E,I)}if(O++,O===z)break}if(b=0,q=e[d]<<8|e[d+1],q<65280)throw new Error("marker was not found");if(!(q>=65488&&q<=65495))break;d+=2}return d-u}function b(e,n){const t=[],{blocksPerLine:r,blocksPerColumn:s}=n,d=r<<3,m=new Int32Array(64),b=new Uint8Array(64);function p(e,t,r){const s=n.quantizationTable;let d,m,b,p,w,k,g,y,P;const C=r;let T;for(T=0;T<64;T++)C[T]=e[T]*s[T];for(T=0;T<8;++T){const e=8*T;0!==C[1+e]||0!==C[2+e]||0!==C[3+e]||0!==C[4+e]||0!==C[5+e]||0!==C[6+e]||0!==C[7+e]?(d=h*C[0+e]+128>>8,m=h*C[4+e]+128>>8,b=C[2+e],p=C[6+e],w=u*(C[1+e]-C[7+e])+128>>8,y=u*(C[1+e]+C[7+e])+128>>8,k=C[3+e]<<4,g=C[5+e]<<4,P=d-m+1>>1,d=d+m+1>>1,m=P,P=b*f+p*l+128>>8,b=b*l-p*f+128>>8,p=P,P=w-g+1>>1,w=w+g+1>>1,g=P,P=y+k+1>>1,k=y-k+1>>1,y=P,P=d-p+1>>1,d=d+p+1>>1,p=P,P=m-b+1>>1,m=m+b+1>>1,b=P,P=w*c+y*i+2048>>12,w=w*i-y*c+2048>>12,y=P,P=k*a+g*o+2048>>12,k=k*o-g*a+2048>>12,g=P,C[0+e]=d+y,C[7+e]=d-y,C[1+e]=m+g,C[6+e]=m-g,C[2+e]=b+k,C[5+e]=b-k,C[3+e]=p+w,C[4+e]=p-w):(P=h*C[0+e]+512>>10,C[0+e]=P,C[1+e]=P,C[2+e]=P,C[3+e]=P,C[4+e]=P,C[5+e]=P,C[6+e]=P,C[7+e]=P)}for(T=0;T<8;++T){const e=T;0!==C[8+e]||0!==C[16+e]||0!==C[24+e]||0!==C[32+e]||0!==C[40+e]||0!==C[48+e]||0!==C[56+e]?(d=h*C[0+e]+2048>>12,m=h*C[32+e]+2048>>12,b=C[16+e],p=C[48+e],w=u*(C[8+e]-C[56+e])+2048>>12,y=u*(C[8+e]+C[56+e])+2048>>12,k=C[24+e],g=C[40+e],P=d-m+1>>1,d=d+m+1>>1,m=P,P=b*f+p*l+2048>>12,b=b*l-p*f+2048>>12,p=P,P=w-g+1>>1,w=w+g+1>>1,g=P,P=y+k+1>>1,k=y-k+1>>1,y=P,P=d-p+1>>1,d=d+p+1>>1,p=P,P=m-b+1>>1,m=m+b+1>>1,b=P,P=w*c+y*i+2048>>12,w=w*i-y*c+2048>>12,y=P,P=k*a+g*o+2048>>12,k=k*o-g*a+2048>>12,g=P,C[0+e]=d+y,C[56+e]=d-y,C[8+e]=m+g,C[48+e]=m-g,C[16+e]=b+k,C[40+e]=b-k,C[24+e]=p+w,C[32+e]=p-w):(P=h*r[T+0]+8192>>14,C[0+e]=P,C[8+e]=P,C[16+e]=P,C[24+e]=P,C[32+e]=P,C[40+e]=P,C[48+e]=P,C[56+e]=P)}for(T=0;T<64;++T){const e=128+(C[T]+8>>4);t[T]=e<0?0:e>255?255:e}}for(let e=0;e<s;e++){const s=e<<3;for(let e=0;e<8;e++)t.push(new Uint8Array(d));for(let o=0;o<r;o++){p(n.blocks[e][o],b,m);let r=0;const a=o<<3;for(let e=0;e<8;e++){const n=t[s+e];for(let e=0;e<8;e++)n[a+e]=b[r++]}}}return t}class p{constructor(){this.jfif=null,this.adobe=null,this.quantizationTables=[],this.huffmanTablesAC=[],this.huffmanTablesDC=[],this.resetFrames()}resetFrames(){this.frames=[]}parse(e){let n=0;function t(){const t=e[n]<<8|e[n+1];return n+=2,t}function r(){const r=t(),s=e.subarray(n,n+r-2);return n+=s.length,s}function o(e){let n,t,r=0,s=0;for(t in e.components)e.components.hasOwnProperty(t)&&(n=e.components[t],r<n.h&&(r=n.h),s<n.v&&(s=n.v));const o=Math.ceil(e.samplesPerLine/8/r),a=Math.ceil(e.scanLines/8/s);for(t in e.components)if(e.components.hasOwnProperty(t)){n=e.components[t];const i=Math.ceil(Math.ceil(e.samplesPerLine/8)*n.h/r),c=Math.ceil(Math.ceil(e.scanLines/8)*n.v/s),l=o*n.h,f=a*n.v,h=[];for(let e=0;e<f;e++){const e=[];for(let n=0;n<l;n++)e.push(new Int32Array(64));h.push(e)}n.blocksPerLine=i,n.blocksPerColumn=c,n.blocks=h}e.maxH=r,e.maxV=s,e.mcusPerLine=o,e.mcusPerColumn=a}let a=t();if(65496!==a)throw new Error("SOI not found");for(a=t();65497!==a;){switch(a){case 65280:break;case 65504:case 65505:case 65506:case 65507:case 65508:case 65509:case 65510:case 65511:case 65512:case 65513:case 65514:case 65515:case 65516:case 65517:case 65518:case 65519:case 65534:{const e=r();65504===a&&74===e[0]&&70===e[1]&&73===e[2]&&70===e[3]&&0===e[4]&&(this.jfif={version:{major:e[5],minor:e[6]},densityUnits:e[7],xDensity:e[8]<<8|e[9],yDensity:e[10]<<8|e[11],thumbWidth:e[12],thumbHeight:e[13],thumbData:e.subarray(14,14+3*e[12]*e[13])}),65518===a&&65===e[0]&&100===e[1]&&111===e[2]&&98===e[3]&&101===e[4]&&0===e[5]&&(this.adobe={version:e[6],flags0:e[7]<<8|e[8],flags1:e[9]<<8|e[10],transformCode:e[11]});break}case 65499:{const r=t()+n-2;for(;n<r;){const r=e[n++],o=new Int32Array(64);if(r>>4==0)for(let t=0;t<64;t++){o[s[t]]=e[n++]}else{if(r>>4!=1)throw new Error("DQT: invalid table spec");for(let e=0;e<64;e++){o[s[e]]=t()}}this.quantizationTables[15&r]=o}break}case 65472:case 65473:case 65474:{t();const r={extended:65473===a,progressive:65474===a,precision:e[n++],scanLines:t(),samplesPerLine:t(),components:{},componentsOrder:[]},s=e[n++];let i;for(let t=0;t<s;t++){i=e[n];const t=e[n+1]>>4,s=15&e[n+1],o=e[n+2];r.componentsOrder.push(i),r.components[i]={h:t,v:s,quantizationIdx:o},n+=3}o(r),this.frames.push(r);break}case 65476:{const r=t();for(let t=2;t<r;){const r=e[n++],s=new Uint8Array(16);let o=0;for(let t=0;t<16;t++,n++)s[t]=e[n],o+=s[t];const a=new Uint8Array(o);for(let t=0;t<o;t++,n++)a[t]=e[n];t+=17+o,r>>4==0?this.huffmanTablesDC[15&r]=d(s,a):this.huffmanTablesAC[15&r]=d(s,a)}break}case 65501:t(),this.resetInterval=t();break;case 65498:{t();const r=e[n++],s=[],o=this.frames[0];for(let t=0;t<r;t++){const t=o.components[e[n++]],r=e[n++];t.huffmanTableDC=this.huffmanTablesDC[r>>4],t.huffmanTableAC=this.huffmanTablesAC[15&r],s.push(t)}const a=e[n++],i=e[n++],c=e[n++],l=m(e,n,o,s,this.resetInterval,a,i,c>>4,15&c);n+=l;break}case 65535:255!==e[n]&&n--;break;default:if(255===e[n-3]&&e[n-2]>=192&&e[n-2]<=254){n-=3;break}throw new Error(`unknown JPEG marker ${a.toString(16)}`)}a=t()}}getResult(){const{frames:e}=this;if(0===this.frames.length)throw new Error("no frames were decoded");this.frames.length>1&&console.warn("more than one frame is not supported");for(let e=0;e<this.frames.length;e++){const n=this.frames[e].components;for(const e of Object.keys(n))n[e].quantizationTable=this.quantizationTables[n[e].quantizationIdx],delete n[e].quantizationIdx}const n=e[0],{components:t,componentsOrder:r}=n,s=[],o=n.samplesPerLine,a=n.scanLines;for(let e=0;e<r.length;e++){const o=t[r[e]];s.push({lines:b(0,o),scaleX:o.h/n.maxH,scaleY:o.v/n.maxV})}const i=new Uint8Array(o*a*s.length);let c=0;for(let e=0;e<a;++e)for(let n=0;n<o;++n)for(let t=0;t<s.length;++t){const r=s[t];i[c]=r.lines[0|e*r.scaleY][0|n*r.scaleX],++c}return i}}class w extends r.Z{constructor(e){super(),this.reader=new p,e.JPEGTables&&this.reader.parse(e.JPEGTables)}decodeBlock(e){return this.reader.resetFrames(),this.reader.parse(new Uint8Array(e)),this.reader.getResult().buffer}}}}]);