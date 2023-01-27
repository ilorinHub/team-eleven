export const clearForm = formObj => {
  for (const [key, value] of Object.entries(formObj)) {
    const keyName = `${key}`
    formObj[keyName] = null
  }
}

export const oddEven = value => (value + 1) % 2 != 1

export const isNumber = (value, min = null) => {
  if (min !== null) {
    if (typeof min !== `number`) throw new Error('Invalid Argument:minimum must be a number')
    if (typeof Number(value) !== `number`) throw new Error('Invalid Argument:value must be a number')
    return Number(value) !== 0 &&
    Number.isFinite(Number(value)) &&
    Number(value) >= Number(min)
  }
  if (typeof Number(value) !== `number`) throw new Error('Invalid Argument:value must be a number')
  return Number(value) !== 0 && Number.isFinite(Number(value))
}

export const makeCurrentLink = (link, path, currentPage) => {
   let newLink;
   // check if query contains a search term
   if ( link.lastIndexOf('?search=') !== -1 ) {
     // strip pagination query
     newLink = link.substr(0, link.lastIndexOf('&page'))
     // get the search term
     const searchTerm = newLink.substr(newLink.lastIndexOf('=')).substr(1)
     // concatenate the url pieces together
     return ( newLink != undefined ) ? `${path}?search=${searchTerm}&page=${currentPage}` : link
   }
   if ( link.lastIndexOf('?page') !== -1 ) {
     newLink = link.substr(0, link.lastIndexOf('?page'))
   }
   if ( link.lastIndexOf('&page') !== -1 )  {
     newLink = link.substr(0, link.lastIndexOf('&page'))
   }
   return ( newLink != undefined ) ? `${newLink}?page=${currentPage}` : link
}

export const disableScroll = () =>  window.scrollTo(0, 0)

export const enableScroll = () => window.onscroll = function() {}
