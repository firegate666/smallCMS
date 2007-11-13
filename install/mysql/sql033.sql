INSERT INTO `template` ( `id` , `class` , `layout` , `content` , `__createdon` , `__changedon` , `backup` , `contenttype` )
VALUES (
NULL , 'admin', 'head', '&lt;?xml version=&quot;1.0&quot; ?&gt; &lt;!DOCTYPE html PUBLIC &quot;-//W3C//DTD XHTML 1.0 Transitional//EN&quot; &quot;http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd&quot;&gt; &lt;html xmlns=&quot;http://www.w3.org/1999/xhtml&quot;&gt; &lt;head&gt; &lt;title&gt;smallCMS Admin&lt;/title&gt; &lt;link href=&quot;?admin/show/css&quot; rel=&quot;stylesheet&quot; type=&quot;text/css&quot;/&gt; &lt;script type=&quot;text/javascript&quot;&gt; function dialog_confirm(question, dest) { if (confirm(question)) location = dest; } &lt;/script&gt; &lt;/head&gt; &lt;body&gt;', NULL , NULL , '', 'text/html'
);

INSERT INTO dbversion(sql_id, sql_subid) VALUES (33, 0);