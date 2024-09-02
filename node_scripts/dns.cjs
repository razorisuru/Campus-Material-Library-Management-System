const dns = require('dns');

dns.lookup('api.pawan.krd', (err, addresses) => {
  if (err) {
    console.error('DNS lookup failed:', err);
  } else {
    console.log('IP addresses:', addresses);
  }
});
