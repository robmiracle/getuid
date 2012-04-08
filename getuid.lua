--
-- getuid.lua -- Get a  Unique ID
--
-- Graciouslly donated to the Public Domain
--
-- Usage:
-- local AppID = "com.yoursite.yourapp"
-- local guid = require("getuid").getuid(AppID)
--
-- Assumptions:  Any use of a UDID is for some use online.  If your app isn't
-- talking to a server somewhere, there is no need to uniquly ID your app.
-- Of course this won't work for things that are trying to get the UDID in the
-- first place, like PubNub, Push Notifications, etc. but it should provide a
-- solution for your use.

module(..., package.seeall)

local http = require("socket.http")
local json = require("json")

function getuid(appid)
    local r, e
    local result

    print("appid", appid)

    r, e = http.request("http://omnigeekmedia.com/api/getuid.php?appid=" .. appid)

    if e == 200 then
        result = json.decode(r)
        return result.uid
    end
    return nil,result.message
end


