source "https://rubygems.org"

# TODO: Write a script that temporarily comments `gem "jekyll, "~> 4.0.0""`
#   and uncomments `gem "github-pages", group :jekyll_plugins` when pushing
#   to GitHub, so that our site will be deployed.
#   Locally, we use Jekyll version 4.x, as that one is much faster at
#   rebuilding the site than the version currently used by GitHub Pages.
#   Also, don't forget to not use any features from version 4.0 (yet).

gem "jekyll", "~> 4.0.0"
# gem "github-pages", group: :jekyll_plugins

group :jekyll_plugins do
  # https://forestry.io/blog/how-i-reduced-my-jekyll-build-time-by-61/
  gem "jekyll-include-cache"
  # Don't need any kind of feed yet.
  # gem "jekyll-feed", "~> 0.6"
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
