source "https://rubygems.org"

if (ENV["JEKYLL_ENV"] == "development")
  gem "jekyll"
else
  gem "github-pages", group: :jekyll_plugins
end

group :jekyll_plugins do
  # https://forestry.io/blog/how-i-reduced-my-jekyll-build-time-by-61/
  gem "jekyll-include-cache"
end

# Windows does not include zoneinfo files, so bundle the tzinfo-data gem.
gem "tzinfo-data", platforms: [:mingw, :mswin, :x64_mingw, :jruby]

# Performance-booster for watching directories on Windows.
gem "wdm", "~> 0.1.0" if Gem.win_platform?

# Keep the GitHub access token and the
# Jekyll environment in an .env file.
gem "dotenv"

# Source: same as `jekyll-include-cache` above.
# Using this doesn't cause any obvious improvements yet since this
# site is currently very small. We'll keep it here for later though.
gem "liquid-c"
