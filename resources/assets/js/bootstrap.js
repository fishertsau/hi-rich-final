window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

// todo: remove
// try {
//   window.$ = window.jQuery = require('jquery');
//
//   require('bootstrap-sass');
// }catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

export const getPublishedSites = () => {
  return getData('/api/sites/list/published');
}

export const getData = (api) => {
  return axios.get(api);
}

export const deleteItem = (api) => {
  return axios.post(api, { _method: 'DELETE' });
}

// 最新消息
export const getNewsCategory = () => {
  return getData('/api/categories/main/news')
}

export const getPublishedNews = () => {
  return getData('/api/news/list')
}

// 相關連結類別
export const getLinkCategory = () => {
  return getData('/api/categories/main/link')
}

export const getPublishedLinks = () => {
  return getData('/api/links/list')
}

// 產品類別
export const getAllProductCategories = () => {
  return getData('/api/categories/all/product')
}

// 產品清單
export const getPublishedProducts = () => {
  return getData('/api/products/list')
}

// 類別
export const getCategory = (id) => {
  return getData(`/api/categories/${id}`);
}


export function ifCategoryInPathname() {
  const uris = window.location.pathname.split('/');
  const catIncluded = uris.includes('category');

  return { uris, catIncluded }
}

export function isEmpty(obj) {
  for(var prop in obj) {
    if (obj.hasOwnProperty(prop)) {
      return false;
    }
  }

  return JSON.stringify(obj) === JSON.stringify({});
}


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: 'your-pusher-key'
// });
