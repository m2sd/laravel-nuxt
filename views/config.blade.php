import { resolve } from 'path'
import config from '{{ $source }}/nuxt.config'

config.mode = 'spa'
config.rootDir = resolve('{{ $source }}')
config.modules = [
    ...config.modules,
    'nuxt-laravel'
]
config.laravel = {
    @if($cache)
    swCache: {
        endpoint: '{{ $cache }}'
    },
    @endif
    dotEnvExport: {{ $export ? 'true' : 'false'}}
}

@if($prefix)
config.router = {
    ...config.router,
    base: '/{{ $prefix }}/'
}
@endif

export default config
