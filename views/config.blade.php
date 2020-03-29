import { resolve } from 'path'
@if($typescript)
import { Configuration } from '@nuxt/types'
@endif

// eslint-disable-next-line import/no-absolute-path
import original from '{{ $source }}/nuxt.config'

const config = { ...original }{{ $typescript ? ' as Configuration' : '' }}

config.mode = 'spa'
config.rootDir = resolve('{{ $source }}')
config.modules = [...(config.modules || []), 'nuxt-laravel']
config.laravel = {
@if($cache)
  swCache: {
    endpoint: '/{{ $cache }}'
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
