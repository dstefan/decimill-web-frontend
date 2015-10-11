<p><strong>ICT Impact Model</strong></p>
<p>The purpose of this model is to estimate the electricity consumption of an ICT
<br  />estate at an organisation.</p>
<p>The main goal is to <code>Minimise Everything</code> while <code>Maximise as much as we can</code>!</p>
<p>By default, the model computes the yearly electricity consumption by multiplying
<br  />the power consumption of each device by <code>h = 8760</code>.</p>
<p>In this model, the overall electricity consumption of an organisation's ICT estate is computed by summing up the electricity consumption of the organisation's servers, network infrastructure, PCs and printers:</p>
<pre><code>elec_overall_cons =
    serv_overall_elec +
    network_overall_elec +
    pc_overall_elec +
    print_oevarll_elec
</code></pre>
<p>Servers' electricity consumption depends on the number and the consumption of house servers, storage and the data centre's infrastructure efficiency (DCIM).</p>
<pre><code>serv_overall_elec  =
    house_serv_num * house_serv_elec * house_serv_DCIM * h +
    ext_serv_num * ext_serv_elec * ext_serv_DCIM * h +
    house_storage_elec * h
</code></pre>
<p>Network electricity consumption relates to the consumption of the core switches, medium-sized switches, small-sized switches and wifi hubs:</p>
<pre><code>network_overall_elec =
    core_switch_num * core_switch_elec * h +
    small_switch_num * small_switch_elec * h +
    wifi_num * wifi_elec * h
</code></pre>
<p>pcEnrg = dskEnrg + lptEnrg + lcdEnrg
<br  />dskEnrg = (stdDskNum * stdDskEnrg * stdDskH) + (powerDskNum * powerDskEnrg * powerDskH) + (gpuDskNum * gpuDskEnrg * gpuDskH) + (thinNum * thinEnrg * thinH)
<br  />lptEnrg   = lptNum * lptEnrg * lptH
<br  />lcdEnrg   = (lcdNum * lcdActiveEnrg * lcdActiveH) + (lcdNum * lcdSleepEnrg * (h - lcdActiveH))
<br  />printEnrg = (printNum * printActiveEnrg * printActiveH) + (printNum * printIdleEnrg * (h - printActiveH))</p>
