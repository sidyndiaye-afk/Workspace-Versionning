@php($nodes = $nodes() ?? [])
<svg {{ $attributes->merge(['class' => trim('lucide-icon ' . $class), 'viewBox' => '0 0 24 24', 'aria-hidden' => 'true', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.8', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round']) }}>
    @foreach ($nodes as $node)
        @if (($node['element'] ?? null) === 'path')
            <path @foreach(($node['attrs'] ?? []) as $k => $v) {{ $k }}="{{ $v }}" @endforeach></path>
        @elseif (($node['element'] ?? null) === 'circle')
            <circle @foreach(($node['attrs'] ?? []) as $k => $v) {{ $k }}="{{ $v }}" @endforeach></circle>
        @elseif (($node['element'] ?? null) === 'polygon')
            <polygon @foreach(($node['attrs'] ?? []) as $k => $v) {{ $k }}="{{ $v }}" @endforeach></polygon>
        @elseif (($node['element'] ?? null) === 'rect')
            <rect @foreach(($node['attrs'] ?? []) as $k => $v) {{ $k }}="{{ $v }}" @endforeach></rect>
        @endif
    @endforeach
</svg>
