
/**
 * MetaParsedown add microlight class to code elements
 * @return Void
 */
window.onload = function()
{
    document.querySelectorAll('pre code').forEach(function(el){
      el.classList.add('microlight');
    });
    microlight.reset();
}