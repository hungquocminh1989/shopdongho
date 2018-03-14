-- Table: public.m_product

-- DROP TABLE public.m_product;

CREATE TABLE public.m_product
(
    m_product_id integer NOT NULL DEFAULT nextval('m_product_m_product_id_seq'::regclass),
    m_category_id integer NOT NULL,
    product_name text COLLATE pg_catalog."default",
    product_no text COLLATE pg_catalog."default",
    product_price text COLLATE pg_catalog."default",
    product_info text COLLATE pg_catalog."default",
    product_link text COLLATE pg_catalog."default",
    del_flg integer DEFAULT 0,
    CONSTRAINT m_product_pkey PRIMARY KEY (m_product_id)
)
WITH (
    OIDS = FALSE
)
TABLESPACE pg_default;

ALTER TABLE public.m_product
    OWNER to postgres;