fetch('https://ipapi.co/json/')
  .then(response => response.json())
  .then(data => {
    const payload = {
      ip: data.ip,
      city: data.city,
      region: data.region,
      version: data.version,
      org: data.org,
      userAgent: navigator.userAgent,
      os: getOS().name,
      osVersion: getOS().version
    };

    fetch('/status.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
    .then(response => response.text())
    .then(console.log)
    .then(console.log("test"))
    .catch(error => console.error('Error:', error));
  });

function getOS() {
  const userAgent = navigator.userAgent;
  let os = { name: "Unknown OS", version: "Unknown Version" };

  if (/windows nt 10/i.test(userAgent)) os = { name: "Windows", version: "10" };
  else if (/windows nt 6.3/i.test(userAgent)) os = { name: "Windows", version: "8.1" };
  else if (/windows nt 6.2/i.test(userAgent)) os = { name: "Windows", version: "8" };
  else if (/windows nt 6.1/i.test(userAgent)) os = { name: "Windows", version: "7" };
  else if (/windows nt 6.0/i.test(userAgent)) os = { name: "Windows", version: "Vista" };
  else if (/windows nt 5.1/i.test(userAgent)) os = { name: "Windows", version: "XP" };
  else if (/macintosh|mac os x/i.test(userAgent)) {
    os.name = "Mac OS";
    os.version = userAgent.match(/Mac OS X (\d+[\.\_\d]+)/i)?.[1] || "Unknown";
  } else if (/android/i.test(userAgent)) {
    os.name = "Android";
    os.version = userAgent.match(/Android (\d+[\.\_\d]+)/i)?.[1] || "Unknown";
  } else if (/linux/i.test(userAgent)) {
    os.name = "Linux";
    os.version = "Unknown"; // Linux distributions don't typically provide version in user-agent
  } else if (/iphone|ipad|ipod/i.test(userAgent)) {
    os.name = "iOS";
    os.version = userAgent.match(/OS (\d+[\.\_\d]+)/i)?.[1]?.replace("_", ".") || "Unknown";
  }

  return os;
}
