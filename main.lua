--
-- getuid - main.lua
--
-- Example to get a non-device based unique ID for your app.
--

local AppID = "com.omnigeekmedia.testapp"
local guid = require("getuid").getuid(AppID)
print(guid)


