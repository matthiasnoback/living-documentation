- Collect plugins
- Collect documents from plugins
- Collect assets from plugins
- Content types:
    - Page
        -> MenuItem
        -> Content
            - Markdown text (will be turned into)
            - Embedded HTML page
- Plugins
    - Glossary
        - Class annotation: @CoreConcept
        - Generate page with sections for each CoreConcept
    - Layers (generic documentation, with configuration)
    - Ports & Adapters
        - Glob pattern to match bounded contexts
        - Glob pattern to match ports
        - Glob pattern to match adapters
        - Generic documentation; point to Alistair's website
        - Description (Port.md, Adapter.md)

RootCollectors:
    - Bounded contexts
      > Layers
        > Infrastructure
          > Ports
            > Adapters

