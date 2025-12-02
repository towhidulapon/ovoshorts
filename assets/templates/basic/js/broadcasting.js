Pusher.logToConsole = true;
const PUSHER_APP_ID = document
  .querySelector("meta[name=P-A-ID]")
  .getAttribute("content");
const PUSHER_CLUSTER = document
  .querySelector("meta[name=P-CLUSTER]")
  .getAttribute("content");
const BASE_URL = document
  .querySelector("meta[name=APP-DOMAIN]")
  .getAttribute("content");
const AUTH_END_POINT = `${BASE_URL}/pusher/auth/:socketId/:channelName`;

var pusher = new Pusher(PUSHER_APP_ID, {
  cluster: PUSHER_CLUSTER,
});

makeAuthEndPointForPusher = (socketId, channelName) => {
  var endpoint = AUTH_END_POINT.replace(":socketId", socketId).replace(
    ":channelName",
    channelName
  );
  return endpoint;
};

const pusherConnection = (channelName, eventName, callback) => {
  pusher.connection.bind("connected", () => {
    const SOCKET_ID = pusher.connection.socket_id;
    const CHANNEL_NAME = `private-${channelName}`;
    pusher.config.authEndpoint = `${BASE_URL}/pusher/auth/${SOCKET_ID}/${CHANNEL_NAME}`;
    let channel = pusher.subscribe(CHANNEL_NAME);
    channel.bind("pusher:subscription_succeeded", function () {
      channel.bind(eventName, function (data) {
        callback(data);
      });
    });
  });
};
