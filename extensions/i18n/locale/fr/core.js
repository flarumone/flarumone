app.translator.plural = function(count) {
  if (count >= 0 && count < 2) {
    return 'one';
    }
  else {
    return 'other';
  }
};
