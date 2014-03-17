<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

        <title>Composer</title>
        <meta name="description" content="Dependency Management for PHP">
        <meta name="viewport" content="width=device-width,initial-scale=1">

        <link rel="stylesheet" href="/css/style.css?v=6">

        <script src="/js/libs/modernizr-2.0.6.min.js"></script>
    </head>

    <body>
        <div id="container">
            <header>
                                <a href="/">Home</a><a class="" href="/doc/00-intro.md">Getting Started</a><a class="" href="/download/">Download</a><a class="active" href="/doc/">Documentation</a><a class="last" href="http://packagist.org/">Browse Packages</a>                            </header>
            <div id="main" role="main">
                            <ul class="toc">
                        <li>
            <a href="#general">General</a> 
                    </li>
            <li>
            <a href="#package-not-found">Package not found</a> 
                    </li>
            <li>
            <a href="#package-not-found-on-travis-ci-org">Package not found on travis-ci.org</a> 
                    </li>
            <li>
            <a href="#need-to-override-a-package-version">Need to override a package version</a> 
                    </li>
            <li>
            <a href="#memory-limit-errors">Memory limit errors</a> 
                    </li>
            <li>
            <a href="#-the-system-cannot-find-the-path-specified-windows-">&quot;The system cannot find the path specified&quot; (Windows)</a> 
                    </li>
            <li>
            <a href="#api-rate-limit-and-oauth-tokens">API rate limit and OAuth tokens</a> 
                    </li>
            <li>
            <a href="#proc-open-fork-failed-errors">proc_open(): fork failed errors</a> 
                    </li>
    
        </ul>
        <h1 id="troubleshooting">Troubleshooting<a href="#troubleshooting" class="anchor">#</a></h1>

<p>This is a list of common pitfalls on using Composer, and how to avoid them.</p>

<h2 id="general">General<a href="#general" class="anchor">#</a></h2>

<ol><li><p>Before asking anyone, run <a href="../03-cli.md#diagnose"><code>composer diagnose</code></a> to check
for common problems. If it all checks out, proceed to the next steps.</p></li>
<li><p>When facing any kind of problems using Composer, be sure to <strong>work with the
latest version</strong>. See <a href="../03-cli.md#self-update">self-update</a> for details.</p></li>
<li><p>Make sure you have no problems with your setup by running the installer's
checks via <code>curl -sS https://getcomposer.org/installer | php -- --check</code>.</p></li>
<li><p>Ensure you're <strong>installing vendors straight from your <code>composer.json</code></strong> via
<code>rm -rf vendor &amp;&amp; composer update -v</code> when troubleshooting, excluding any
possible interferences with existing vendor installations or <code>composer.lock</code>
entries.</p></li>
</ol><h2 id="package-not-found">Package not found<a href="#package-not-found" class="anchor">#</a></h2>

<ol><li><p>Double-check you <strong>don't have typos</strong> in your <code>composer.json</code> or repository
branches and tag names.</p></li>
<li><p>Be sure to <strong>set the right
<a href="../04-schema.md#minimum-stability">minimum-stability</a></strong>. To get started or be
sure this is no issue, set <code>minimum-stability</code> to "dev".</p></li>
<li><p>Packages <strong>not coming from <a href="https://packagist.org/">Packagist</a></strong> should
always be <strong>defined in the root package</strong> (the package depending on all
vendors).</p></li>
<li><p>Use the <strong>same vendor and package name</strong> throughout all branches and tags of
your repository, especially when maintaining a third party fork and using
<code>replace</code>.</p></li>
</ol><h2 id="package-not-found-on-travis-ci-org">Package not found on travis-ci.org<a href="#package-not-found-on-travis-ci-org" class="anchor">#</a></h2>

<ol><li><p>Check the <a href="#package-not-found">"Package not found"</a> item above.</p></li>
<li><p>If the package tested is a dependency of one of its dependencies (cyclic
dependency), the problem might be that composer is not able to detect the version
of the package properly. If it is a git clone it is generally alright and Composer
will detect the version of the current branch, but travis does shallow clones so
that process can fail when testing pull requests and feature branches in general.
The best solution is to define the version you are on via an environment variable
called COMPOSER_ROOT_VERSION. You set it to <code>dev-master</code> for example to define
the root package's version as <code>dev-master</code>.
Use: <code>before_script: COMPOSER_ROOT_VERSION=dev-master composer install</code> to export
the variable for the call to composer.</p></li>
</ol><h2 id="need-to-override-a-package-version">Need to override a package version<a href="#need-to-override-a-package-version" class="anchor">#</a></h2>

<p>Let say your project depends on package A which in turn depends on a specific
version of package B (say 0.1) and you need a different version of that
package - version 0.11.</p>

<p>You can fix this by aliasing version 0.11 to 0.1:</p>

<p>composer.json:</p>

<pre><code>{
    "require": {
        "A": "0.2",
        "B": "0.11 as 0.1"
    }
}
</code></pre>

<p>See <a href="aliases.md">aliases</a> for more information.</p>

<h2 id="memory-limit-errors">Memory limit errors<a href="#memory-limit-errors" class="anchor">#</a></h2>

<p>If composer shows memory errors on some commands:</p>

<pre><code>PHP Fatal error:  Allowed memory size of XXXXXX bytes exhausted &lt;...&gt;
</code></pre>

<p>The PHP <code>memory_limit</code> should be increased.</p>

<blockquote>
  <p><strong>Note:</strong> Composer internally increases the <code>memory_limit</code> to <code>512M</code>.
  If you have memory issues when using composer, please consider <a href="https://github.com/composer/composer/issues">creating
  an issue ticket</a> so we can look into it.</p>
</blockquote>

<p>To get the current <code>memory_limit</code> value, run:</p>

<pre><code>php -r "echo ini_get('memory_limit').PHP_EOL;"
</code></pre>

<p>Try increasing the limit in your <code>php.ini</code> file (ex. <code>/etc/php5/cli/php.ini</code> for
Debian-like systems):</p>

<pre><code>; Use -1 for unlimited or define an explicit value like 512M
memory_limit = -1
</code></pre>

<p>Or, you can increase the limit with a command-line argument:</p>

<pre><code>php -d memory_limit=-1 composer.phar &lt;...&gt;
</code></pre>

<h2 id="-the-system-cannot-find-the-path-specified-windows-">"The system cannot find the path specified" (Windows)<a href="#-the-system-cannot-find-the-path-specified-windows-" class="anchor">#</a></h2>

<ol><li>Open regedit.</li>
<li>Search for an <code>AutoRun</code> key inside <code>HKEY_LOCAL_MACHINE\Software\Microsoft\Command Processor</code>
or <code>HKEY_CURRENT_USER\Software\Microsoft\Command Processor</code>.</li>
<li>Check if it contains any path to non-existent file, if it's the case, just remove them.</li>
</ol><h2 id="api-rate-limit-and-oauth-tokens">API rate limit and OAuth tokens<a href="#api-rate-limit-and-oauth-tokens" class="anchor">#</a></h2>

<p>Because of GitHub's rate limits on their API it can happen that Composer prompts
for authentication asking your username and password so it can go ahead with its work.</p>

<p>If you would prefer not to provide your GitHub credentials to Composer you can
manually create a token using the following procedure:</p>

<ol><li><p><a href="https://github.com/settings/applications">Create</a> an OAuth token on GitHub.
<a href="https://github.com/blog/1509-personal-api-tokens">Read more</a> on this.</p></li>
<li><p>Add it to the configuration running <code>composer config -g github-oauth.github.com &lt;oauthtoken&gt;</code></p></li>
</ol><p>Now Composer should install/update without asking for authentication.</p>

<h2 id="proc-open-fork-failed-errors">proc_open(): fork failed errors<a href="#proc-open-fork-failed-errors" class="anchor">#</a></h2>

<p>If composer shows proc_open() fork failed on some commands:</p>

<pre><code>PHP Fatal error: Uncaught exception 'ErrorException' with message 'proc_open(): fork failed - Cannot allocate memory' in phar
</code></pre>

<p>This could be happening because the VPS runs out of memory and has no Swap space enabled.</p>

<pre><code>[root@my_tiny_vps htdocs]# free -m
total used free shared buffers cached
Mem: 2048 357 1690 0 0 237
-/+ buffers/cache: 119 1928
Swap: 0 0 0
</code></pre>

<p>To enable the swap you can use for example:</p>

<pre><code>/bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
/sbin/mkswap /var/swap.1
/sbin/swapon /var/swap.1
</code></pre>

    <p class="fork-and-edit">
        Found a typo? Something is wrong in this documentation? Just <a href="http://github.com/composer/composer/edit/master/doc/articles/troubleshooting.md">fork and edit</a> it!
    </p>
            </div>
            <footer>
                                
                <p class="license">Composer and all content on this site are released under the <a href="https://github.com/composer/composer/blob/master/LICENSE">MIT license</a>.</p>
            </footer>
        </div>

        
        <script>
            var _gaq=[['_setAccount','UA-26723099-2'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
            g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
