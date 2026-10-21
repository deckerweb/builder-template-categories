/* Native dialogs retain link and close fallbacks when another script fails. */
(() => {
 'use strict';
 if(window.dwlHistoryBound)return;window.dwlHistoryBound=true;
 let previous=null;
 const dialog=()=>document.getElementById('dwl-history');
 const native=window.HTMLDialogElement?.prototype;
 const close=()=>{const d=dialog();if(!d?.open)return;try{native.close.call(d);}catch(e){d.removeAttribute('open');d.hidden=true;}previous?.focus();};
 document.addEventListener('click',event=>{
  const t=event.target.closest?.('[data-dwl-history]');const d=dialog();
  if(t&&d&&typeof native?.showModal==='function'){
   previous=document.activeElement;d.hidden=false;
   try{native.showModal.call(d);event.preventDefault();}catch(e){d.hidden=true;}return;
  }
  if(event.target.closest?.('[data-dwl-close]')){event.preventDefault();close();}
  else if(d?.open&&event.target===d){const r=d.getBoundingClientRect();if(event.clientX<r.left||event.clientX>r.right||event.clientY<r.top||event.clientY>r.bottom)close();}
 },true);
 document.addEventListener('keydown',event=>{if(event.key==='Escape'&&dialog()?.open){event.preventDefault();close();}},true);
 document.addEventListener('close',event=>{if(event.target===dialog()){event.target.hidden=true;previous?.focus();}},true);
 document.addEventListener('click',async event=>{
  if(!event.target.closest?.('[data-dwl-copy]'))return;
  const field=document.getElementById('dwl-diagnostics');if(!field)return;
  try{await navigator.clipboard.writeText(field.value);document.querySelector('[data-dwl-copy-status]').textContent=window.dwlInline?.copied||'Copied.';}
  catch(e){field.focus();field.select();document.querySelector('[data-dwl-copy-status]').textContent=window.dwlInline?.copyManual||'Select and copy the text.';}
 });
})();
/* Catalog actions keep the current page, filters and scroll position intact. */
(($) => {
 'use strict';
 $(function () {
  if (!window.dwlInline) return;
  let busy = false, pending = null;
  const credentials = () => {
   const c = window.wp?.updates?.filesystemCredentials;
   return c ? {hostname:c.ftp.hostname,username:c.ftp.username,password:c.ftp.password,connection_type:c.ftp.connectionType,public_key:c.ssh.publicKey,private_key:c.ssh.privateKey,_fs_nonce:c.fsNonce} : {};
  };
  const finish = (job, message, failed) => {
   busy = false; pending = null;
   job.button.disabled = false; job.button.textContent = job.label;
   job.form.removeAttribute('aria-busy');
   job.status.textContent = message;
   job.status.classList.toggle('dwl-inline-error', failed);
   if (window.wp?.a11y) wp.a11y.speak(message, failed ? 'assertive' : 'polite');
  };
  const apply = (job, data) => {
   delete job.form.dataset.dwlRecover;delete job.form.dataset.dwlLabel;
   finish(job, data.message || '', false);
   const card=job.form.closest('.dwl-card');if(card && (data.installed||data.active||data.updated)){let state=card.querySelector('.dwl-install-state');if(!state){state=document.createElement('p');state.className='dwl-install-state';card.querySelector('.dwl-title')?.after(state);}state.textContent=data.active?(data.network_active?dwlInline.networkActive:dwlInline.active):dwlInline.inactive;}
   if(data.version){const version=job.form.closest('.dwl-card')?.querySelector('footer span:last-child');if(version)version.textContent='v'+data.version;}
   if (data.next) {
    job.form.dataset.dwlAction = 'activate';job.form.querySelector('[name="_wpnonce"]').value = data.next.nonce;
    const url = new URL(job.form.action);url.searchParams.set('action','dwl_activate');job.form.action=url.href;
    job.button.textContent = data.next.label;job.button.classList.add('button-primary');
   } else if (data.updated || data.active || data.installed) {job.button.textContent=data.message;job.button.disabled=true;}
  };
  const checkStatus = (job) => {
   job.button.textContent=dwlInline.checking;job.form.setAttribute('aria-busy','true');
   const unavailable = (message) => {
    finish(job,message || dwlInline.failed,true);
    job.form.dataset.dwlRecover='1';job.form.dataset.dwlLabel=job.label;job.button.textContent=dwlInline.status;
   };
   $.ajax({url:dwlInline.url,method:'POST',dataType:'json',data:{action:'dwl_inline_status',operation:job.form.dataset.dwlAction,slug:job.form.dataset.dwlSlug,network:job.form.dataset.dwlNetwork,_wpnonce:job.form.querySelector('[name="_wpnonce"]').value}}).done(response=>{
    const data=response?.data || {};
    if (!response.success || data.pending) {unavailable(data.message);return;}
    if(!data.installed && job.failure){finish(job,job.failure+' '+(data.message||''),true);return;}apply(job,data);
   }).fail(()=>unavailable(dwlInline.failed));
  };
  // Native upgrader filters may verify the Core updates nonce. The server still
  // independently verifies the operation- and slug-bound Library _wpnonce.
  const send = (job) => {
   $.ajax({url:dwlInline.url,method:'POST',dataType:'json',data:{...credentials(),_ajax_nonce:window.wp?.updates?.ajaxNonce,action:'dwl_inline',operation:job.form.dataset.dwlAction,slug:job.form.dataset.dwlSlug,network:job.form.dataset.dwlNetwork,_wpnonce:job.form.querySelector('[name="_wpnonce"]').value}}).done(response => {
    const data = response?.data || {};
    if (!response.success) {
     if (data.credentials && document.getElementById('request-filesystem-credentials-dialog') && window.wp?.updates) {
      pending = job;
      wp.updates.filesystemCredentials.available = false;
      wp.updates.ajaxLocked = true;
      wp.updates.$elToReturnFocusToFromCredentialsModal = $(job.button);
      wp.updates.requestForCredentialsModalOpen();
      return;
     }
     finish(job, data.message || dwlInline.failed, true); return;
    }
    apply(job,data);
   }).fail(xhr => {job.failure = String(xhr.responseText).trim()==='-1' ? dwlInline.interrupted : (xhr.status===403 ? dwlInline.forbidden : dwlInline.failed);job.status.textContent=job.failure;checkStatus(job);});
  };
  $('#deckerweb-library').on('submit', '.dwl-card form[data-dwl-action]', function(event) {
   if (!['install','activate','update'].includes(this.dataset.dwlAction)) return;
   event.preventDefault(); if (busy) return;
   busy = true;
   const button = this.querySelector('button[type="submit"]');
   let status = this.parentElement.querySelector('.dwl-inline-status');
   if (!status) {status=document.createElement('p');status.className='dwl-inline-status';status.setAttribute('role','status');status.setAttribute('aria-live','polite');this.after(status);}
   const job={form:this,button,status,label:this.dataset.dwlLabel || button.textContent};
   status.textContent='';status.classList.remove('dwl-inline-error');button.disabled=true;
   button.textContent=this.dataset.dwlAction==='install'?dwlInline.installing:(this.dataset.dwlAction==='update'?dwlInline.updating:dwlInline.activating);
   this.setAttribute('aria-busy','true');if(this.dataset.dwlRecover==='1')checkStatus(job);else send(job);
  });
  // WordPress's modal handler records credentials in memory before this retry.
  $('#request-filesystem-credentials-dialog').on('submit.dwl', 'form', () => {
   if (pending) {const job=pending;pending=null;send(job);}
  });
  const cancel = () => {if(pending) {const job=pending;finish(job,dwlInline.cancelled,false);job.button.focus();}};
  $('#request-filesystem-credentials-dialog').on('click.dwl','.cancel-button',cancel).on('keydown.dwl',event=>{if(event.key==='Escape')cancel();});
 });
})(jQuery);

/* Shared preferences and catalog controls have a native same-admin fallback. */
(($) => {
 'use strict';
 $(document).on('submit', 'form[data-dwl-action]', function(event) {
  const operation=this.dataset.dwlAction;
  if (!window.dwlInline || !['preferences','dismiss','refresh'].includes(operation)) return;
  event.preventDefault();
  const form=this, button=form.querySelector('button[type="submit"],input[type="submit"]');
  if(form.dataset.dwlBusy==='1')return;form.dataset.dwlBusy='1';if(button)button.disabled=true;
  let status=form.querySelector('.dwl-control-status');
  if(!status){status=document.createElement('p');status.className='dwl-control-status';status.setAttribute('role','status');form.append(status);}
  const data=$(form).serializeArray();data.push({name:'action',value:'dwl_controls'},{name:'operation',value:operation},{name:'network',value:form.dataset.dwlNetwork});
  $.ajax({url:dwlInline.url,method:'POST',dataType:'json',data}).done(response=>{
   status.textContent=response.data?.message || dwlInline.failed;
   if(response.success && operation==='preferences'){document.getElementById('dwl-settings-saved')?.remove();}
   if(response.success && operation==='dismiss'){form.closest('.notice')?.remove();}
   if(response.success && operation==='preferences' && form.querySelector('[name="hide_only"]')){document.querySelectorAll('#deckerweb-library .dwl-grid,#deckerweb-library .dwl-filter').forEach(el=>{el.hidden=true;});}
   if(response.success && operation==='refresh'){window.location.reload();}
  }).fail(()=>{status.textContent=dwlInline.failed;}).always(()=>{delete form.dataset.dwlBusy;if(button)button.disabled=false;});
 });
})(jQuery);

/* Personal sorting and notice dismissal retain native administration fallbacks. */
(($)=>{
 $(document).on('change','select[name="dwl_sort"]',function(){const b=this.form.querySelector('[name="dwl_shuffle"]');if(b)b.hidden=this.value!=='random';if(window.fetch&&window.dwlInline)this.form.requestSubmit(this.form.querySelector('.dwl-filter-controls button[name="dwl_series"]'));});
 $(document).on('submit','form',function(event){
  if(this.querySelector('[name="action"]')?.value!=='dwl_conflict_dismiss'||!window.dwlInline)return;
  event.preventDefault();const form=this;const data=$(form).serializeArray();
  $.ajax({url:dwlInline.url,method:'POST',dataType:'json',data}).done(r=>{if(r.success)form.closest('.notice')?.remove();});
 });
})(jQuery);

(($)=>{
 let viewPending=false;
 $(document).on('submit','form.dwl-filter,form.dwl-filter-chip',function(event){
  if(!window.fetch||!window.dwlInline)return;event.preventDefault();if(viewPending)return;viewPending=true;
  const form=this;const button=event.originalEvent?.submitter;const data=new FormData(form);if(button?.name)data.set(button.name,button.value);
  form.setAttribute('aria-busy','true');
  const controls=[...form.querySelectorAll('button,input,select')].filter(el=>!el.disabled);controls.forEach(el=>el.disabled=true);
  fetch(form.getAttribute('action'),{method:'POST',body:data,credentials:'same-origin'}).then(async response=>{
   if(!response.ok)throw Error('view');const html=await response.text();const doc=new DOMParser().parseFromString(html,'text/html');const next=doc.getElementById('deckerweb-library');const current=document.getElementById('deckerweb-library');
   if(!next||!current)throw Error('view');current.replaceWith(next);const focus=next.querySelector(button?.name==='dwl_shuffle'?'[name="dwl_shuffle"]':'[name="dwl_sort"]');focus?.focus();
  }).catch(()=>{let message=form.querySelector('[role="status"]');if(!message){message=document.createElement('p');message.setAttribute('role','status');form.append(message);}message.textContent=dwlInline.failed;}).finally(()=>{viewPending=false;form.removeAttribute('aria-busy');controls.forEach(el=>el.disabled=false);});
 });
})(jQuery);
