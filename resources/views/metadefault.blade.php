<meta name="description" content="@yield('title') - {{ getSetting('web_description') }}">
<meta property="og:title" content="@yield('title')" />
<meta property="og:description" content="{{ getSetting('web_description') }}" />
<meta property="og:image" content="{{ berkas( getSetting('logo')) }}" />
<meta property="og:image:secure_url" content="{{ berkas( getSetting('logo')) }}" />
<meta property="og:image:width" content="100" />
<meta property="og:image:height" content="100" />
