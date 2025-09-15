import '../scss/tabler.scss'
import '../scss/app.scss'
import '../scss/utilities.scss'

import { Collapse, Toast, Modal } from 'bootstrap'

import { getElements } from '../../js/utils'

const toggleSidebar = () => {
  document.body.classList.toggle('sidebar-open')
}

const modalAlert = (relatedEl, data) => {
  const modalEl = document.getElementById('modal-alert')
  const modal = Modal.getOrCreateInstance(modalEl, { backdrop: 'static' })
  const modalBody = modalEl.querySelector('.modal-body')
  const modalFooter = modalEl.querySelector('.modal-footer')
  const dismissModal = (modal) => {
    modal.hide()
  }
  let btnClass = ['btn', 'btn-primary']
  if (data.button && data.button.className) {
    btnClass = data.button.className.split(' ')
  }
  const button = document.createElement('button')
  button.classList.add(...btnClass)
  button.innerHTML = (data.button && data.button.text) ? data.button.text : 'OK'
  button.addEventListener('click', (event) => {
    event.preventDefault()
    const callback = (data.button?.callback && typeof data.button.callback === "function") ? data.button.callback : dismissModal
    callback.call(this, modal)
  })

  let bodyContent = ''
  if (data.heading) {
    bodyContent = `<h3>${data.heading}</h3>`
  }
  if (data.message) {
    bodyContent = `${bodyContent}<div class="text-muted">${data.message}</div>`
  }
  if (data.icon) {
    bodyContent = `${data.icon}<div class="flex-grow-1">${bodyContent}</div>`
  }
  modalBody.innerHTML = bodyContent

  modalFooter.innerHTML = ''
  if (data.showCancelButton) {
    const cancelButton = document.createElement('button')
    cancelButton.classList.add(...['btn', 'btn-outline-secondary'])
    cancelButton.innerHTML = '<i class="fas fa-times me-1"></i> Batal'
    cancelButton.addEventListener('click', () => {
      dismissModal(modal)
    })
    modalFooter.append(cancelButton)
  }
  modalFooter.append(button)

  modal.show(relatedEl)

  return modal
}

const alertAndDelete = (deleteBtn, callback) => {
  if (typeof callback !== "function"){
    callback = async (modal) => {
      modal._element.querySelectorAll('button').forEach((btn) => {
        btn.disabled = true
        if (btn.classList.contains('btn-danger')) {
          const faIconClass = btn.querySelector('.fa')?.classList || null
          if (faIconClass){
            faIconClass.replace('fa-check', 'fa-spinner')
            faIconClass.add('fa-spin')
          }
        }
      })

      const reqOptions = {
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="x-csrf-token"]')?.getAttribute('content'),
          accept: 'application/json'
        }
      }
      let url = deleteBtn.dataset.url
      if ( !url && deleteBtn.form) {
        url = (deleteBtn.form && deleteBtn.form.action) || document.location.href

        const data = new FormData(deleteBtn.form)
        if (data.get('_method') != 'DELETE'){
          data.set('_method', 'DELETE')
        }
        reqOptions.method = 'POST'
        reqOptions.body = data
      }

      //const response = await post(url, data, false)
      if (url){
        const response = await fetch(url, reqOptions)
        document.location.reload()
      } else {
        modal.hide()
      }
    }
  }
  modalAlert(deleteBtn, {
    heading: (deleteBtn.dataset.heading) || 'Are you sure to delete?',
    message: (deleteBtn.dataset.message) || 'It will be permanently deleted and cannot be recovered.',
    icon: '<i class="fa fa-circle-exclamation fa-xl me-3 text-danger"></i>',
    button: {
      'className': 'btn btn-danger',
      'text': '<i class="fa fa-check me-1"></i> Yes',
      callback
    },
    showCancelButton: true
  })
}

const mayHaveChildren = (checkItem) => {
  if (checkItem.form) {
    const childrens = getElements(`[data-bs-parent="${checkItem.value}"`, checkItem.form)
    childrens.forEach((children) => {
      children.checked = checkItem.checked
      mayHaveChildren(children)
      children.disabled = checkItem.checked
    })
  }
}

const handleCheckAll = function (){
  const checkAllEl = this;
  const form = checkAllEl.form || document
  const checkItems = getElements('[data-bs-toggle="check-item"]', form)
  checkItems.forEach((checkItem) => {
    checkItem.checked = checkAllEl.checked
    mayHaveChildren(checkItem)
  })
}

const handleCheckItem = function(){
  const checkItemEl = this
  const form = checkItemEl.form || document
  const checkAllEl = form.querySelector('[data-bs-toggle="check-all"]')
  const checkItemEls = getElements('[data-bs-toggle="check-item"]', form)

  mayHaveChildren(checkItemEl)

  if (checkAllEl){
    const checkSelected = getElements('[data-bs-toggle="check-item"]:checked', form)
    if (checkSelected.length === 0) {
      checkAllEl.indeterminate = false
      checkAllEl.checked = false
    } else if (checkItemEls.length === checkSelected.length) {
      checkAllEl.indeterminate = false
      checkAllEl.checked = true
    } else {
      checkAllEl.indeterminate = true
      checkAllEl.checked = false
    }
  }
}

const handleDeleteAll = function(event){
  event.preventDefault()

  const form = this.form || document.querySelector('#admin-form')
  if (!form)
    return false;

  if (form.querySelectorAll('[data-bs-toggle="check-item"]:checked').length) {
    alertAndDelete(this)
  } else {
    modalAlert(this, {
      message: 'There are no items to delete. Please select an item.',
      icon: '<i class="fa fa-circle-info fa-xl me-3 text-warning"></i>',
      button: {
        className: 'btn btn-warning'
      }
    })
  }
}

const handleDeleteItem = function (event){
  event.preventDefault()

  alertAndDelete(this)
}

window.addEventListener('DOMContentLoaded', () => {
  getElements('[data-bs-toggle="sidebar"]').map((sidebarTogglerEl) => {
    sidebarTogglerEl.addEventListener('click', () => toggleSidebar.call())
  })

  getElements('form[method="post"].need-validation').map(form => {
    form.addEventListener('submit', event => {
      if ( !form.checkValidity()){
        event.preventDefault()
        form.classList.add('was-validated')
        return
      }
    })
  })

  getElements('[data-bs-toggle="check-all"]').map((checkAllEl) => {
    checkAllEl.addEventListener('click', handleCheckAll)
  })

  getElements('[data-bs-toggle="check-item"]').map((checkItemEl) => {
    checkItemEl.addEventListener('click', handleCheckItem)
  })

  getElements('[data-bs-action="delete"]').map(btn => btn.addEventListener('click', handleDeleteAll))

  getElements('[data-bs-action="delete-item"]').map(btn => btn.addEventListener('click', handleDeleteItem))
})